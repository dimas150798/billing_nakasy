<?php

/**
 * RouterosAPI_SSL.php
 * Custom Mikrotik API SSL connector without composer
 * By ChatGPT for Dimas
 */

class RouterosAPI_SSL
{
    var $debug = false;
    var $connected = false;
    var $port = 8729;
    var $timeout = 3;
    var $socket;
    var $error;

    function connect($ip, $login, $password, $port = 8729)
    {
        $this->port = $port;

        $ctx = stream_context_create([
            'ssl' => [
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            ]
        ]);

        $this->socket = stream_socket_client(
            'ssl://' . $ip . ':' . $this->port,
            $errno,
            $errstr,
            $this->timeout,
            STREAM_CLIENT_CONNECT,
            $ctx
        );

        if (!$this->socket) {
            $this->error = "Koneksi gagal: $errstr ($errno)";
            return false;
        }

        stream_set_timeout($this->socket, $this->timeout);
        $this->connected = true;

        // Login
        $request = ['/login'];
        $response = $this->comm($request);

        if (!isset($response[0]['ret'])) {
            $this->error = "Gagal mendapatkan challenge dari Mikrotik.";
            return false;
        }

        $chal = pack('H*', $response[0]['ret']);
        $md5 = md5(chr(0) . $password . $chal, true);
        $md5str = '00' . bin2hex($md5);

        $request = [
            '/login',
            '=name=' . $login,
            '=response=' . $md5str
        ];

        $response = $this->comm($request);
        if (isset($response[0]) && $response[0] == '!done') {
            return true;
        } else {
            $this->error = "Login gagal ke Mikrotik.";
            return false;
        }
    }

    function disconnect()
    {
        fclose($this->socket);
        $this->connected = false;
    }

    function write($command)
    {
        $written = fwrite($this->socket, $command);
        fflush($this->socket);
        return $written;
    }

    function read($length)
    {
        return fread($this->socket, $length);
    }

    function readSentence()
    {
        $sentence = [];
        while (true) {
            $word = $this->readWord();
            if ($word == '') {
                break;
            }
            $sentence[] = $word;
        }
        return $sentence;
    }

    function readWord()
    {
        $length = ord($this->read(1));
        if ($length & 0x80) {
            $length &= 0x7F;
            $length = ($length << 8) + ord($this->read(1));
        }
        if ($length == 0) {
            return '';
        }
        return $this->read($length);
    }

    function writeWord($word)
    {
        $len = strlen($word);
        if ($len < 0x80) {
            $this->write(chr($len));
        } else {
            $this->write(chr(($len >> 8) | 0x80));
            $this->write(chr($len & 0xFF));
        }
        $this->write($word);
    }

    function writeSentence($arr)
    {
        foreach ($arr as $word) {
            $this->writeWord($word);
        }
        $this->writeWord('');
    }

    function readResponse()
    {
        $response = [];
        while (true) {
            $sentence = $this->readSentence();
            if (count($sentence) == 0) {
                continue;
            }
            if ($sentence[0] == '!done') {
                break;
            } elseif ($sentence[0] == '!re') {
                $arr = [];
                for ($i = 1; $i < count($sentence); $i++) {
                    $e = explode('=', $sentence[$i], 3);
                    if (isset($e[1]) && isset($e[2])) {
                        $arr[$e[1]] = $e[2];
                    }
                }
                $response[] = $arr;
            }
        }
        return $response;
    }

    function comm($com)
    {
        if (is_array($com)) {
            $this->writeSentence($com);
        } else {
            $this->writeSentence([$com]);
        }
        return $this->readResponse();
    }
}
