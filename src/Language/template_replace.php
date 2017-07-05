//not using this file yet

<!-- <?php
  class Template {

    public $filename;
    public $assigned_vars = array();

    public function set($key, $value) {
      $this->assigned_vars[$key] = $value;
    }

    public function display() {
      if(file_exists($this->filename)) {
        $output = file_get_contents($this->filename);
        foreach($this->assigned_vars as $key => $value) {
          $output = preg_replace('/{'.$key.'}/', $value, $output);
        }
        echo $output;
      } else {
        echo "*** Missing template error ***";
      }
    }
  }

  $template = new Template();
  $template->filename = "index.php";
  $template->set('Theseus and Minotaur forum', "Template Test");
  // $template->set('content', "This is a test of templating using search and replace.");
  $template->display();

?> -->
