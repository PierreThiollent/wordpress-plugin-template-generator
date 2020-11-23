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

        // Ask plugin slug
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

        // Get file names (directories and subdirectories)
        $file_list = $file_helper->get_directory_content($plugin_destination_folder);

        // Rename all plugin files recursively
        $file_helper->rename_files($file_list, $plugin_slug);

        // Ask plugin name
        $input->setPrompt('Plugin Name : ');
        $plugin_name = $input->read();

        // If plugin name is blank
        if (!$plugin_name) {
            while (!$plugin_name) {
                $this->getPrinter()->error('The plugin name can\'t be empty');
                $input->setPrompt('Plugin name : ');
                $this->getPrinter()->newline();
                $plugin_name = $input->read();
            }
        }

        // Replace plugin name (WordPress Plugin Boilerplate)
        $file_helper->rename_files_content('/WordPress Plugin Boilerplate/', $plugin_name, $plugin_destination_folder);

        $input->setPrompt('Plugin URI : ');
        $plugin_uri = $input->read();

        // If plugin URI is blank
        if (!$plugin_uri) {
            while (!$plugin_uri) {
                $this->getPrinter()->error('The plugin URI can\'t be empty');
                $input->setPrompt('Plugin URI : ');
                $this->getPrinter()->newline();
                $plugin_uri = $input->read();
            }
        } elseif (!filter_var($plugin_uri, FILTER_VALIDATE_URL)) {
            while (!filter_var($plugin_uri, FILTER_VALIDATE_URL)) {
                $this->getPrinter()->error('The plugin URI is not valid.');
                $input->setPrompt('Plugin URI : ');
                $this->getPrinter()->newline();
                $plugin_uri = $input->read();
            }
        }

        // Replace plugin URI
        $file_helper->rename_files_content('/http:\/\/example.com/', $plugin_uri, $plugin_destination_folder);
        $file_helper->rename_files_content('/http:\/\/example.com\/plugin-name-uri\//', $plugin_uri, $plugin_destination_folder);

        // Replace plugin-name string into all files (comments, filenames of require, etc)
        $file_helper->rename_files_content('/plugin-name/', $plugin_slug, $plugin_destination_folder);

        // Replace classes name (Plugin_Name)
        $file_helper->rename_files_content('/Plugin_Name/', str_replace(' ', '_', ucwords($plugin_name, ' ')), $plugin_destination_folder);
        // Replace const PLUGIN_NAME_VERSION
        $file_helper->rename_files_content('/PLUGIN_NAME/', str_replace(' ', '_', strtoupper($plugin_name)), $plugin_destination_folder);
        // Replace function names
        $file_helper->rename_files_content('/plugin_name/', str_replace(' ', '_', strtolower($plugin_name)), $plugin_destination_folder);

        // Ask author name
        $input->setPrompt('👨🏻‍💻 Author name : ');
        $author_name = $input->read();

        // If author name is not empty
        if (!$author_name) {
            while (!$author_name) {
                $this->getPrinter()->error('The author name can\'t be empty.');
                $input->setPrompt('Author name : ');
                $this->getPrinter()->newline();
                $author_name = $input->read();
            }
        }

        // Replace author name (Your Name or Your Company)
        $file_helper->rename_files_content('/Your Name or Your Company/', $author_name, $plugin_destination_folder);

        // Ask author email
        $input->setPrompt('👨🏻‍💻 Author email : ');
        $author_email = $input->read();

        // If author email is blank
        if (!$author_email) {
            while (!$author_email) {
                $this->getPrinter()->error('The author email can\'t be empty.');
                $input->setPrompt('Author email : ');
                $this->getPrinter()->newline();
                $author_email = $input->read();
            }
            // If author email is not a valid email
        } elseif (!filter_var($author_email, FILTER_VALIDATE_EMAIL)) {
            while (!filter_var($author_email, FILTER_VALIDATE_EMAIL)) {
                $this->getPrinter()->error('The author email is not valid.');
                $input->setPrompt('Author email : ');
                $this->getPrinter()->newline();
                $author_email = $input->read();
            }
        }
        // Replace author name and email (Your Name <email@example.com>)
        $file_helper->rename_files_content('/Your Name <email@example.com>/', $author_name . ' <' . $author_email . '>', $plugin_destination_folder);

        // Ask author URI
        $input->setPrompt('👨🏻‍💻 Author URI : ');
        $author_uri = $input->read();

        // If author email is blank
        if (!$author_uri) {
            while (!$author_uri) {
                $this->getPrinter()->error('👨🏻‍💻 The author URI can\'t be empty.');
                $input->setPrompt('👨🏻‍💻 Author URI : ');
                $this->getPrinter()->newline();
                $author_uri = $input->read();
            }
            // If author URI is not a valid email
        } elseif (!filter_var($author_uri, FILTER_VALIDATE_URL)) {
            while (!filter_var($author_uri, FILTER_VALIDATE_URL)) {
                $this->getPrinter()->error('👨🏻‍💻 The author URI is not valid.');
                $input->setPrompt('👨🏻‍💻 Author URI : ');
                $this->getPrinter()->newline();
                $author_uri = $input->read();
            }
        }

        // Replace author URI
        $file_helper->rename_files_content('/http:\/\/example.com\//', $plugin_uri, $plugin_destination_folder);
    }

    // TODO Ask for plugin description
}
