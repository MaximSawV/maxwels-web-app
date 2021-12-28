<?php
/**
 * Created by PhpStorm.
 * User: maxim
 * Date: 12/27/21
 * Time: 9:33 AM
 */
// src/Command/CreateUserCommand.php
namespace App\Command;

use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use App\Entity\User;
use Symfony\Component\Console\Helper\ProgressBar;

class CreateUserCommand extends Command
{
    private $userRepository;
    private $hasher;
    private $entityManager;

    public function __construct(UserRepository $userRepository,
                                UserPasswordHasherInterface $hasher,
                                EntityManagerInterface $entityManager)
    {
        $this->userRepository = $userRepository;
        $this->hasher = $hasher;
        $this->entityManager = $entityManager;
        parent::__construct();
    }

    // the name of the command (the part after "bin/console")
    protected static $defaultName = 'app:create-user';

    protected function configure(): void
    {
        $this->setDescription('Create User');
        $this->setHelp('This command allows you to create a user');
        $this->addArgument('Username', null, "Username");
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $userRoles = [];
        $helper = $this->getHelper('question');
        $progressBar = new ProgressBar($output, 12);

        #Setting up questions
        $questionUsername = new Question('*Username : ');
        $questionRoles = new Question('Roles <fg=green>[null]</>: ', null);
        $questionProceedAddingRoles = new ConfirmationQuestion('Adding another role? <fg=green>[no]</>', false, '/^(y|j)/i');
        $questionPlainPassword = new Question('*Password: ');
        $questionEmail = new Question('*Email: ');
        $questionIsVerified = new ConfirmationQuestion('Verified: <fg=green>[no]</> ', false, '/^(y|j)/i');
        $questionPaymentInformation = new Question('Payment information: <fg=green>[null]</> ', null);
        $questionSubscribed = new ConfirmationQuestion('Subscribed: <fg=green>[no]</> ', false, '/^(y|j)/i');
        $questionCustomerProgrammer = new ChoiceQuestion('Customer, Programmer or both: <fg=green>[customer]</> ', ['customer', 'programmer', 'both'], 'customer');
        $questionStatus = new ChoiceQuestion('Status: <fg=green>[Offline]</> ', ['Online', 'Busy', 'Offline'], 'Offline');



        #ask
        $userName = $helper->ask($input, $output, $questionUsername);
        $newRole = $helper->ask($input, $output, $questionRoles);
        if ($newRole != null)
        {
            array_push($userRoles, $newRole);
        }

        $addAnotherRole = $helper->ask($input, $output, $questionProceedAddingRoles);
        while ($addAnotherRole){
            $newRole = $helper->ask($input, $output, $questionRoles);
            if ($newRole == null)
            {
                $addAnotherRole = false;
            } else {
                array_push($userRoles, $newRole);
                $addAnotherRole = $helper->ask($input, $output, $questionProceedAddingRoles);
            }
        }
        $userPassword = $helper->ask($input, $output, $questionPlainPassword);
        $userEmail = $helper->ask($input, $output, $questionEmail);
        $userVerified = $helper->ask($input, $output, $questionIsVerified);
        $userPaymentInfo = $helper->ask($input, $output, $questionPaymentInformation);
        $userSubscribed = $helper->ask($input, $output, $questionSubscribed);
        $userCoP = $helper->ask($input, $output, $questionCustomerProgrammer);
        $userStatus = $helper->ask($input, $output, $questionStatus);


        #Create User

        $user = new User();
        $progressBar->advance();
        $user->setUsername($userName);
        $progressBar->advance();
        $user->setRoles($userRoles);
        $progressBar->advance();
        $user->setPassword($userPassword);
        $progressBar->advance();
        $user->setEmail($userEmail);
        $progressBar->advance();
        $user->setIsVerified($userVerified);
        $progressBar->advance();
        $user->setPaymentInformation($userPaymentInfo);
        $progressBar->advance();
        $user->setSubscribed($userSubscribed);
        $progressBar->advance();
        $user->setCustomerOrProgrammer($userCoP);
        $progressBar->advance();
        $user->setStatus($userStatus);
        $progressBar->advance();

        $this->entityManager->persist($user);
        $progressBar->advance();
        $this->entityManager->flush();
        $progressBar->advance();
        $progressBar->finish();

        $output->writeln($userName . " Erstellt");

        return Command::SUCCESS;

        // or return this if some error happened during the execution
        // (it's equivalent to returning int(1))
        // return Command::FAILURE;

        // or return this to indicate incorrect command usage; e.g. invalid options
        // or missing arguments (it's equivalent to returning int(2))
        // return Command::INVALID
    }
}