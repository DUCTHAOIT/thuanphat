<?php
/*~ class.smtp.php
.---------------------------------------------------------------------------.
| Minimal SMTP transport class, compatible with classes/phpmailer.class.php |
| (PHPMailer 2.2.1 style API: Connect, Hello, StartTLS, Authenticate, Mail, |
| Recipient, Data, Reset, Quit, Close, Connected, do_debug).                |
'---------------------------------------------------------------------------'
*/

class SMTP {

	var $do_debug = false;
	var $smtp_conn = false;
	var $error = '';
	var $CRLF = "\r\n";

	function Connect($host, $port = 25, $tval = 30) {
		$errno = 0;
		$errstr = '';
		$this->smtp_conn = @stream_socket_client($host . ':' . $port, $errno, $errstr, $tval);
		if (!$this->smtp_conn) {
			$this->error = "Failed to connect to server $host:$port ($errno) $errstr";
			if ($this->do_debug) echo "SMTP -> ERROR: " . $this->error . $this->CRLF;
			return false;
		}
		stream_set_timeout($this->smtp_conn, $tval);
		$announce = $this->get_lines();
		if ($this->do_debug) echo "SMTP -> FROM SERVER:" . $this->CRLF . $announce;
		return true;
	}

	function Connected() {
		if (!empty($this->smtp_conn) && is_resource($this->smtp_conn)) {
			$status = stream_get_meta_data($this->smtp_conn);
			if ($status['eof']) {
				fclose($this->smtp_conn);
				$this->smtp_conn = false;
				return false;
			}
			return true;
		}
		return false;
	}

	function Hello($host = '') {
		if ($host == '') $host = 'localhost';
		if ($this->sendCommand('EHLO', 'EHLO ' . $host, 250)) return true;
		return $this->sendCommand('HELO', 'HELO ' . $host, 250);
	}

	function StartTLS() {
		if (!$this->sendCommand('STARTTLS', 'STARTTLS', 220)) return false;
		return (bool) @stream_socket_enable_crypto($this->smtp_conn, true, STREAM_CRYPTO_METHOD_TLS_CLIENT);
	}

	function Authenticate($username, $password) {
		if (!$this->sendCommand('AUTH', 'AUTH LOGIN', 334)) return false;
		if (!$this->sendCommand('Username', base64_encode($username), 334)) return false;
		if (!$this->sendCommand('Password', base64_encode($password), 235)) return false;
		return true;
	}

	function Mail($from) {
		return $this->sendCommand('MAIL FROM', 'MAIL FROM:<' . $from . '>', 250);
	}

	function Recipient($to) {
		return $this->sendCommand('RCPT TO', 'RCPT TO:<' . $to . '>', array(250, 251));
	}

	function Data($msg_data) {
		if (!$this->sendCommand('DATA', 'DATA', 354)) return false;
		$msg_data = str_replace("\r\n", "\n", $msg_data);
		$msg_data = str_replace("\r", "\n", $msg_data);
		$lines = explode("\n", $msg_data);
		$data = '';
		foreach ($lines as $line) {
			if (isset($line[0]) && $line[0] == '.') $line = '.' . $line;
			$data .= $line . $this->CRLF;
		}
		fwrite($this->smtp_conn, $data . '.' . $this->CRLF);
		$reply = $this->get_lines();
		if ($this->do_debug) echo "SMTP -> REPLY: " . $reply;
		if ((int) substr($reply, 0, 3) != 250) {
			$this->error = 'DATA not accepted: ' . $reply;
			return false;
		}
		return true;
	}

	function Reset() {
		return $this->sendCommand('RSET', 'RSET', 250);
	}

	function Quit($close_on_error = true) {
		$result = $this->sendCommand('QUIT', 'QUIT', 221);
		if ($close_on_error || $result) $this->Close();
		return $result;
	}

	function Close() {
		if ($this->smtp_conn) fclose($this->smtp_conn);
		$this->smtp_conn = false;
	}

	function sendCommand($cmd_name, $commandstring, $expect) {
		if (!$this->smtp_conn) {
			$this->error = "Cannot send $cmd_name, no connection";
			return false;
		}
		fwrite($this->smtp_conn, $commandstring . $this->CRLF);
		$reply = $this->get_lines();
		$code = (int) substr($reply, 0, 3);
		if ($this->do_debug) echo "SMTP -> " . $cmd_name . ': ' . $commandstring . $this->CRLF . "SMTP -> REPLY: " . $reply;
		$expectArr = is_array($expect) ? $expect : array($expect);
		if (!in_array($code, $expectArr)) {
			$this->error = "$cmd_name command failed: $reply";
			return false;
		}
		return true;
	}

	function get_lines() {
		$data = '';
		while (is_resource($this->smtp_conn) && !feof($this->smtp_conn)) {
			$line = fgets($this->smtp_conn, 515);
			if ($line === false) break;
			$data .= $line;
			if (isset($line[3]) && $line[3] == ' ') break;
		}
		return $data;
	}
}
