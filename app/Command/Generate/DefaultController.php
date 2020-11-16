<?php

namespace App\Command\Generate;

use Minicli\Command\CommandController;
use Minicli\Input;

class DefaultController extends CommandController
{
    public function handle()
    {
        $input = new Input();

        $this->getPrinter()->info('INFO');
        $this->getPrinter()->info('This command will let you generate a template plugin folder.');
        $this->getPrinter()->info('It will ask you for the plugin name, slug, URI, the author name, URI and email.');
        $this->getPrinter()->newline();

        $input->setPrompt('Plugin name : ');

        $plugin_name = $input->read();
        echo $plugin_name;
    }
}
