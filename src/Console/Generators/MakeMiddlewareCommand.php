<?php

namespace Vanthink\Modules\Console\Generators;

class MakeMiddlewareCommand extends MakeCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:module:middleware
    	{slug : The slug of the module.}
    	{name : The name of the middleware class.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new module middleware class';

    /**
     * String to store the command type.
     *
     * @var string
     */
    protected $type = 'Middleware';

    /**
     * Module folders to be created.
     *
     * @var array
     */
    protected $listFolders = [
        'Http/Middleware/',
    ];

    /**
     * Module files to be created.
     *
     * @var array
     */
    protected $listFiles = [
        '{{filename}}.php',
    ];

    /**
     * Module stubs used to populate defined files.
     *
     * @var array
     */
    protected $listStubs = [
        'default' => [
            'middleware.stub',
        ],
    ];

    /**
     * Resolve Container after getting file path.
     *
     * @param string $FilePath
     *
     * @return array
     */
    protected function resolveByPath($filePath)
    {
        $this->container['filename']  = $this->makeFileName($filePath);
        $this->container['namespace'] = $this->getNamespace($filePath);
        $this->container['path']      = $this->getBaseNamespace();
        $this->container['classname'] = basename($filePath);
    }

    /**
     * Replace placeholder text with correct values.
     *
     * @return string
     */
    protected function formatContent($content)
    {
        return str_replace(
            [
                '{{filename}}',
                '{{path}}',
                '{{namespace}}',
                '{{classname}}',
            ],
            [
                $this->container['filename'],
                $this->container['path'],
                $this->container['namespace'],
                $this->container['classname'],
            ],
            $content
        );
    }
}
