<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitbbff7135bb2d256935475e0d5b02a440
{
    public static $prefixLengthsPsr4 = array (
        'A' => 
        array (
            'Angle\\' => 6,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Angle\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static $prefixesPsr0 = array (
        'o' => 
        array (
            'org\\bovigo\\vfs\\' => 
            array (
                0 => __DIR__ . '/..' . '/mikey179/vfsStream/src/main/php',
            ),
        ),
    );

    public static $classMap = array (
        'Angle\\Engine\\Template\\Engine' => __DIR__ . '/../..' . '/src/TemplateEngine/Engine.php',
        'Angle\\Engine\\Template\\Syntax' => __DIR__ . '/../..' . '/src/TemplateEngine/Syntax.php',
        'org\\bovigo\\vfs\\DotDirectory' => __DIR__ . '/..' . '/mikey179/vfsStream/src/main/php/org/bovigo/vfs/DotDirectory.php',
        'org\\bovigo\\vfs\\Quota' => __DIR__ . '/..' . '/mikey179/vfsStream/src/main/php/org/bovigo/vfs/Quota.php',
        'org\\bovigo\\vfs\\content\\FileContent' => __DIR__ . '/..' . '/mikey179/vfsStream/src/main/php/org/bovigo/vfs/content/FileContent.php',
        'org\\bovigo\\vfs\\content\\LargeFileContent' => __DIR__ . '/..' . '/mikey179/vfsStream/src/main/php/org/bovigo/vfs/content/LargeFileContent.php',
        'org\\bovigo\\vfs\\content\\SeekableFileContent' => __DIR__ . '/..' . '/mikey179/vfsStream/src/main/php/org/bovigo/vfs/content/SeekableFileContent.php',
        'org\\bovigo\\vfs\\content\\StringBasedFileContent' => __DIR__ . '/..' . '/mikey179/vfsStream/src/main/php/org/bovigo/vfs/content/StringBasedFileContent.php',
        'org\\bovigo\\vfs\\vfsStream' => __DIR__ . '/..' . '/mikey179/vfsStream/src/main/php/org/bovigo/vfs/vfsStream.php',
        'org\\bovigo\\vfs\\vfsStreamAbstractContent' => __DIR__ . '/..' . '/mikey179/vfsStream/src/main/php/org/bovigo/vfs/vfsStreamAbstractContent.php',
        'org\\bovigo\\vfs\\vfsStreamBlock' => __DIR__ . '/..' . '/mikey179/vfsStream/src/main/php/org/bovigo/vfs/vfsStreamBlock.php',
        'org\\bovigo\\vfs\\vfsStreamContainer' => __DIR__ . '/..' . '/mikey179/vfsStream/src/main/php/org/bovigo/vfs/vfsStreamContainer.php',
        'org\\bovigo\\vfs\\vfsStreamContainerIterator' => __DIR__ . '/..' . '/mikey179/vfsStream/src/main/php/org/bovigo/vfs/vfsStreamContainerIterator.php',
        'org\\bovigo\\vfs\\vfsStreamContent' => __DIR__ . '/..' . '/mikey179/vfsStream/src/main/php/org/bovigo/vfs/vfsStreamContent.php',
        'org\\bovigo\\vfs\\vfsStreamDirectory' => __DIR__ . '/..' . '/mikey179/vfsStream/src/main/php/org/bovigo/vfs/vfsStreamDirectory.php',
        'org\\bovigo\\vfs\\vfsStreamException' => __DIR__ . '/..' . '/mikey179/vfsStream/src/main/php/org/bovigo/vfs/vfsStreamException.php',
        'org\\bovigo\\vfs\\vfsStreamFile' => __DIR__ . '/..' . '/mikey179/vfsStream/src/main/php/org/bovigo/vfs/vfsStreamFile.php',
        'org\\bovigo\\vfs\\vfsStreamWrapper' => __DIR__ . '/..' . '/mikey179/vfsStream/src/main/php/org/bovigo/vfs/vfsStreamWrapper.php',
        'org\\bovigo\\vfs\\visitor\\vfsStreamAbstractVisitor' => __DIR__ . '/..' . '/mikey179/vfsStream/src/main/php/org/bovigo/vfs/visitor/vfsStreamAbstractVisitor.php',
        'org\\bovigo\\vfs\\visitor\\vfsStreamPrintVisitor' => __DIR__ . '/..' . '/mikey179/vfsStream/src/main/php/org/bovigo/vfs/visitor/vfsStreamPrintVisitor.php',
        'org\\bovigo\\vfs\\visitor\\vfsStreamStructureVisitor' => __DIR__ . '/..' . '/mikey179/vfsStream/src/main/php/org/bovigo/vfs/visitor/vfsStreamStructureVisitor.php',
        'org\\bovigo\\vfs\\visitor\\vfsStreamVisitor' => __DIR__ . '/..' . '/mikey179/vfsStream/src/main/php/org/bovigo/vfs/visitor/vfsStreamVisitor.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitbbff7135bb2d256935475e0d5b02a440::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitbbff7135bb2d256935475e0d5b02a440::$prefixDirsPsr4;
            $loader->prefixesPsr0 = ComposerStaticInitbbff7135bb2d256935475e0d5b02a440::$prefixesPsr0;
            $loader->classMap = ComposerStaticInitbbff7135bb2d256935475e0d5b02a440::$classMap;

        }, null, ClassLoader::class);
    }
}
