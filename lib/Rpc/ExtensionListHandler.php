<?php

namespace Phpactor\Extension\ExtensionManager\Rpc;

use Phpactor\Extension\ExtensionManager\Model\ExtensionRepository;
use Phpactor\Extension\ExtensionManager\Model\ExtensionState;
use Phpactor\Extension\Rpc\Handler;
use Phpactor\Extension\Rpc\Response\EchoResponse;
use Phpactor\MapResolver\Resolver;

class ExtensionListHandler implements Handler
{
    /**
     * @var ExtensionRepository
     */
    private $repository;

    public function __construct(ExtensionRepository $repository)
    {
        $this->repository = $repository;
    }

    public function name(): string
    {
        return 'extension_list';
    }

    public function configure(Resolver $resolver)
    {
    }

    public function handle(array $arguments)
    {
        $output = [];
        foreach ($this->repository->extensions() as $extension) {
            $output[] = sprintf(
                "[%s] %-30s %s (%s)",
                $this->formatState($extension->state()),
                $extension->name(),
                $extension->description(),
                $extension->version()
            );
        }

        return EchoResponse::fromMessage(implode(PHP_EOL, $output));
    }

    private function formatState(ExtensionState $extensionState)
    {
        if ($extensionState->isPrimary()) {
            return '✔*';
        }

        if ($extensionState->isSecondary()) {
            return '✔ ';
        }

        return '  ';
    }
}
