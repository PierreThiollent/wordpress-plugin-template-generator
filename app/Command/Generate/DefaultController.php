<?php

namespace App\Command\Generate;

use Minicli\Command\CommandController;
use Minicli\Input;
use App\Helpers\FileHelper;

class DefaultController extends CommandController
{
    public function handle()
    {
        $this->getPrinter()->info('INFO');
        $this->getPrinter()->info('This command will let you generate a template plugin folder.');
        $this->getPrinter()->info('It will ask you for the plugin name, slug, URI, the author name, URI and email.');
        $this->getPrinter()->newline();

        $input = new Input();
        $file_helper = new FileHelper();

        $input->setPrompt('Plugin slug : ');
        $plugin_slug = $input->read();

        // If plugin slug is blank
        if (!$plugin_slug) {
            while (!$plugin_slug) {
                $this->getPrinter()->error('The plugin slug can\'t be empty');
                $input->setPrompt('Plugin slug : ');
                $this->getPrinter()->newline();
                $plugin_slug = $input->read();
            }

            // If plugin slug doesn't match the pattern
        } elseif (!preg_match('/^(([a-z0-9])+[-]?([a-z0-9])+)+[-]?([a-z0-9])+$/', $plugin_slug)) {
            while (!preg_match('/^(([a-z0-9])+[-]?([a-z0-9])+)+[-]?([a-z0-9])+$/', $plugin_slug)) {
                $this->getPrinter()->error('The plugin slug doesn\'t match the pattern');
                $input->setPrompt('Plugin slug : ');
                $this->getPrinter()->newline();
                $plugin_slug = $input->read();
            }
        }

        $plugin_destination_folder = './source/' . $plugin_slug;
        // Copy template plugin into new folder with plugin slug name
        $file_helper->recursive_copy('./source/plugin-name', $plugin_destination_folder);

        $fileList = $file_helper->getDirectoryContent($plugin_destination_folder);

        // Rename all plugin files
        foreach ($fileList as $file) {
            rename($file, preg_replace('/plugin-name/', $plugin_slug, $file));
        }

        $input->setPrompt('Plugin Name : ');
        $plugin_name = $input->read();
    }
}
