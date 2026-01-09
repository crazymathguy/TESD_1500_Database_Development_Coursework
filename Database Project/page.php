<?php
class Page {
	public $title = "Sean's Summer Camp";
	public $styles;
	public $header;
	public $content;

	public function __construct($styles, $header, $content) {
		$this->styles = $styles;
		$this->header = $header;
		$this->content = $content;
	}

	public function __set($name, $value) {
		$this->$name = $value;
	}

	public function Display() {
		echo "<html>\n<head>\n";
		$this -> DisplayTitle();
		$this -> DisplayStyles();
		echo "</head>\n<body>\n";
		$this -> DisplayHeader();
		echo $this->content;
		$this -> DisplayFooter();
		echo "</body>\n</html>";
	}

	public function DisplayTitle() {
		echo "<title>".$this->title."</title>";
	}

	public function DisplayStyles() {
		$this -> DisplayStyleSheet("styles");
		foreach ($this->styles as $style) {
			$this -> DisplayStyleSheet($style);
		}
	}

	public function DisplayStyleSheet($sheet) {
		echo '<link href="'.$sheet.'.css" type="text/css" rel="stylesheet">';
	}

	public function DisplayHeader() {
		?>
		<!-- page header -->
		<header><h1>Sean's Summer Camp</h1></header>
		<?php
		if ($this->header != "") {
			echo "<h1>".$this->header."</h1>";
		}
	}

	public function DisplayFooter() {
		?>
		<footer>
			Contact: Sean Briggs &nbsp; (111) 111-1111 &nbsp; admin@example.com
		</footer>
		<?php
	}
}
?>