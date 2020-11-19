<?php

namespace App\Command\Generate;

use Minicli\Command\CommandController;
use Minicli\Input;
use App\Helpers\FileHelper;

class DefaultController extends CommandController
{
    public function handle()
    {
        // TODO: Define default path for each OS
        switch (\PHP_OS_FAMILY) {
        }

        $this->getPrinter()->display('Generate plugin template');
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

        // TODO:
        $plugin_destination_folder = './source/' . $plugin_slug;

        // Copy template plugin into new folder with plugin slug name
        $file_helper->recursive_copy('./source/plugin-name', $plugin_destination_folder);

        $file_list = $file_helper->get_directory_content($plugin_destination_folder);

        // Rename all plugin files
        $file_helper->rename_files($file_list, $plugin_slug);

        // Replace plugin-name
        $file_helper->rename_files_content('/plugin-name/', $plugin_slug, $plugin_destination_folder);

        $input->setPrompt('Plugin Name : ');
        $plugin_name = $input->read();

        // Remove whitespaces and add CamelCase for Classes
        $plugin_name = str_replace(' ', '_', ucwords($plugin_name, ' '));

        // Replace Plugin_Name
        $file_helper->rename_files_content('/Plugin_Name/', $plugin_name, $plugin_destination_folder);
    }
}
