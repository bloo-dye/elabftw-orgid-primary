<?php

/**
 * @author Nicolas CARPi <nico-git@deltablot.email>
 * @copyright 2023 Nicolas CARPi
 * @see https://www.elabftw.net Official website
 * @license AGPL-3.0
 * @package elabftw
 */

declare(strict_types=1);

namespace Elabftw\Commands;

use Elabftw\Enums\BasePermissions;
use Elabftw\Enums\Storage;
use Elabftw\Import\Eln;
use Elabftw\Interfaces\StorageInterface;
use Elabftw\Models\Users;
use Elabftw\Services\UsersHelper;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Import experiments from a .eln
 */
#[AsCommand(name: 'users:import')]
class ImportUser extends Command
{
    public function __construct(private StorageInterface $Fs)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Import experiments from an ELN archive')
            ->setHelp('This command will import experiments from a provided ELN archive. It is more reliable than using the web interface as it will not suffer from timeouts.')
            ->addArgument('userid', InputArgument::REQUIRED, 'User id')
            ->addArgument('file', InputArgument::REQUIRED, 'Name of the file to import present in cache/elab folder');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $userid = (int) $input->getArgument('userid');
        $filePath = $this->Fs->getPath((string) $input->getArgument('file'));
        $uploadedFile = new UploadedFile($filePath, 'input.eln', null, null, true);
        $teamid = (int) (new UsersHelper($userid))->getTeamsFromUserid()[0]['id'];
        $Eln = new Eln(new Users($userid, $teamid), sprintf('experiments:%d', $userid), BasePermissions::User->toJson(), BasePermissions::User->toJson(), $uploadedFile, Storage::CACHE->getStorage()->getFs());
        $Eln->import();

        $output->writeln(sprintf('Experiments successfully imported for user with ID %d.', $userid));

        return Command::SUCCESS;
    }
}
