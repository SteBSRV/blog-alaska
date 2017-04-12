<?php
/* lib/vendors/RSSParser/RSSParser.php */
namespace RSSParser;

class RSSParser
{
	protected $rss,
			  $title = 'Billet Simple Pour l\'Alaska',
			  $link = 'http://bspa.dev/',
			  $description = 'Un roman en ligne',
			  $path = '';

	const INVALID_DATA = 1;

	public function __construct($dataList)
	{
		if (is_null($dataList)) {
			throw new Exception("Error Processing Request", INVALID_DATA);
		}

		$this->setHeader();
		$this->setContent($dataList);
		$this->writeContent();
	}

	public function setHeader()
	{
		$rss = '<?xml version="1.0" encoding="UTF-8" ?>';
	    $rss .= '<rss version="2.0">';
	    $rss .= '<channel>';
	    $rss .= '<title>'.$this->title.'</title>';
	    $rss .= '<link>'.$this->link.'</link>';
	    $rss .= '<description>'.$this->description.'</description>';

	    $this->rss = $rss;
	}

	public function setContent($dataList)
	{
		$rss = '';

		foreach ($dataList as $data) {
		    $rss .= '<item>';
		    $rss .= '<title>' . $data->getTitle() . '</title>';
		    $rss .= '<link>http://bspa.dev/episode-'. $data->getId() . '.html</link>';
		    $rss .= '<description>' . strip_tags(html_entity_decode($data->getContent())) . '</description>';
		    $rss .= '<pubDate>' . $data->getAddDate()->format('D, Y-m-d H:i:s') . '</pubDate>';
		    $rss .= '</item>';
	    }
	   
	    $rss .= '</channel>';
	    $rss .= '</rss>';

	    $this->rss .= $rss;
	}

	public function writeContent()
	{
		$fp = fopen($this->path.'flux.xml', 'w+');

	    fputs($fp, $this->rss);
	    fclose($fp);	
	}

	public function getRss()
	{
		return $this->path.'flux.xml';
	}
}
?>
