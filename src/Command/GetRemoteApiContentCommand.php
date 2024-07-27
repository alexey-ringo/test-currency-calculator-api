<?php
declare(strict_types=1);

namespace App\Command;

use App\Provider\RemoteApiProvider;
use App\Repository\CurrencyRepository;
use Exception;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;


#[AsCommand(name: 'remote_api:save')]
class GetRemoteApiContentCommand extends Command
{
    public function __construct(
        private readonly RemoteApiProvider  $provider,
        private readonly CurrencyRepository $repository,
    )
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setDescription('Save currency rates from remote APIs');
    }

    /**
     * @throws Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $currencyRatesContent = $this->provider->getRemoteApisContent();
        $this->repository->saveToFile($currencyRatesContent);

        return Command::SUCCESS;
    }
}
