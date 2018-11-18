<?php

namespace Phpactor\Extension\ExtensionManager\Model;

interface ExtensionRepository
{
    public function installedExtensions(): Extensions;

    public function find(string $extension): Extension;

    public function has(string $extension): bool;

    public function extensions(): Extensions;
}
