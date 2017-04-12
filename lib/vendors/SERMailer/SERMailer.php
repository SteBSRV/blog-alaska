<?php
/* lib/vendors/SERMailer/SERMailer.php */
namespace SERMailer;

class SERMailer
{
	protected $boundary,
			  $passage_ligne,
			  $mail,
			  $sujet,
			  $message,
			  $content_html,
			  $content_txt,
			  $header;

	const INVALID_MAIL = 1;
	const INVALID_SUBJECT = 2;
	const INDALID_MESSAGE = 3;

	public function __construct($mail, $subject, $content)
	{
		$this->boundary = "-----=".md5(rand());
		$this->mail = $mail;
		$this->subject = $subject;
		$this->content_html = $content;
		$this->content_txt = strip_tags($content);
		$this->createMail();
	}

	public function createMail()
	{
		// Filtrage des serveurs présentant des bugs.
		if (!preg_match("#^[a-z0-9._-]+@(hotmail|live|msn).[a-z]{2,4}$#", $this->mail)) 
		{
			$this->passage_ligne = "\r\n";
		}
		else
		{
			$this->passage_ligne = "\n";
		}

		$this->createHeader();
		$this->createMessage();

	}

	public function createHeader()
	{
		//=====Création du header de l'e-mail.
		$header = "From: \"Jean Forteroche\"<contact@bspa.dev>".$this->passage_ligne;
		$header.= "Reply-to: \"Jean Forteroche\" <contact@bspa.dev>".$this->passage_ligne;
		$header.= "MIME-Version: 1.0".$this->passage_ligne;
		$header.= "Content-Type: multipart/alternative;".$this->passage_ligne." boundary=\"$this->boundary\"".$this->passage_ligne;
		//==========
		$this->header = $header;
	}

	public function createMessage()
	{
		$message_html = $this->content_html;
		$message_txt = $this->content_txt;
		//=====Création du message.
		$message = $this->passage_ligne."--".$this->boundary.$this->passage_ligne;
		$message.= "Content-Type: multipart/alternative;".$this->passage_ligne." boundary=\"$this->boundary\"".$this->passage_ligne;
		$message.= $this->passage_ligne."--".$this->boundary.$this->passage_ligne;
		//=====Ajout du message au format texte.
		$message.= "Content-Type: text/plain; charset=\"ISO-8859-1\"".$this->passage_ligne;
		$message.= "Content-Transfer-Encoding: 8bit".$this->passage_ligne;
		$message.= $this->passage_ligne.$message_txt.$this->passage_ligne;
		//==========
		 
		$message.= $this->passage_ligne."--".$this->boundary.$this->passage_ligne;
		 
		//=====Ajout du message au format HTML.
		$message.= "Content-Type: text/html; charset=\"ISO-8859-1\"".$this->passage_ligne;
		$message.= "Content-Transfer-Encoding: 8bit".$this->passage_ligne;
		$message.= $this->passage_ligne.$message_html.$this->passage_ligne;
		//==========
		 
		//=====On ferme la boundary
		$message.= $this->passage_ligne."--".$this->boundary."--".$this->passage_ligne;
		$message.= $this->passage_ligne."--".$this->boundary.$this->passage_ligne;

		$this->message = $message;
	}

	public function send()
	{
		if (!isset($this->mail)) {
			throw new Exception("L'adresse email n'est pas valide.", INVALID_MAIL);
		}
		if (!isset($this->subject)) {
			throw new Exception("Le sujet n'est pas valide.", INVALID_SUBJECT);
		}
		if (!isset($this->message)) {
			throw new Exception("Le message n'est pas valide.", INVALID_MESSAGE);
		}

		var_dump($this->message . '#######' . $this->header);

		mail($this->mail, $this->subject, $this->message, $this->header);
 	}

}
?>
