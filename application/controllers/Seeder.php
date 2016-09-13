<?php
 
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
 
/**
 * Seeder Class
 *
 * Creates fake data for the demo site
 *
 * Example Command: 
 *    php index.php Seeder demo_seed
 */
class Seeder extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
 
        // can only be called from the command line
        if (!$this->input->is_cli_request()) {
            exit('Direct access is not allowed');
        }

        // TODO: Add restriction so this can only be run within certain environments?
 
        // initiate faker
        $this->faker = Faker\Factory::create();
 
        // load required models
        $this->load->model('Contribution_model');
        $this->load->model('donation/Donation_model');
        $this->load->model('payment/Payment_model');
    }
 
    /**
     * seed local database
     */
    function demo_seed()
    {
        // purge existing data
        $this->Contribution_model->removeAllContributors();
        $this->Donation_model->removeAllDonations();
        $this->Payment_model->removeAllPayments();

        // seed users
        $this->_basic_seed(10000);
    }
 
    /**
     * seed contributors and donations
     *
     * @param int $limit
     */
    function _basic_seed($limit)
    {
        echo "seeding $limit contributors";

        $committeeIds = $this->Contribution_model->getCommitteeIds();
 
        // create a bunch of base buyer accounts
        for ($i = 0; $i < $limit; $i++) {
            echo ".";

            $firstName = $this->faker->firstName();
            $middleName = $this->faker->firstName();
            $middleInitial = substr($middleName,0,1);
            $lastName = $this->faker->lastName();
            $email = $firstName.$lastName.'@'.$this->faker->safeEmailDomain();
            $address = $this->faker->streetAddress();
            $state = $this->faker->stateAbbr();
            $zip = substr($this->faker->postcode(),0,5);
            $city = $this->faker->city();
            $employer = $this->faker->company();
            $occupation = ucwords($this->faker->word());
            $transactionDate = $this->faker->dateTimeBetween('-8 months', 'now');
            $transactionAmount = $this->faker->biasedNumberBetween(10, 2000, 'sqrt');
            $creditCardType = $this->faker->creditCardType();
            $creditCardNumber = substr($this->faker->creditCardNumber(),0,4);
            $notes = $this->faker->optional(0.2, $default = '')->text(200);
            $ipAddress = $this->faker->ipv4();
            $committeeId = $this->faker->randomElement($committeeIds);
            $authCode = substr($this->faker->md5(),-6);
            $transactionFileName = $this->faker->isbn10();
 
            $this->Contribution_model->insertContributor(array(
                'filer_identification_number' => $committeeId,
                'name'              => $firstName.' '.$middleInitial.' '.$lastName,
                'firstname'         => $firstName,
                'lastname'          => $lastName,
                'city'              => $city,
                'state'             => $state,
                'zip_code'          => $zip,
                'employer'          => $employer,
                'occupation'        => $occupation,
                'transaction_date'  => $transactionDate->format('Y-m-d'),
                'transaction_amt'   => $transactionAmount,
                'memo_text'         => $notes,
            ));

            // Insert as a donation 10% of the time
            if($this->faker->boolean(10)) {
                $donationId = $this->Donation_model->save(array(
                    'firstname'         => $firstName,
                    'lastname'          => $lastName,
                    'middleinitial'     => $middleInitial,
                    'streetaddress'     => $address,
                    'city'              => $city,
                    'state'             => $state,
                    'zip'               => $zip,
                    'employer'          => $employer,
                    'occupation'        => $occupation,
                    'email'             => $email,
                    'cardtype'          => $creditCardType,
                    'cclast4'           => $creditCardNumber,
                    'notes'             => $notes,
                    'amount'            => $transactionAmount,
                    'InsertDate'        => $transactionDate->format('Y-m-d H:i:s'),
                ));

                $this->Payment_model->save(array(
                    'PaymentTransactionId'  => $donationId,
                    'Gateway'               => 'NMI',
                    'TransactionStatusId'   => 1,
                    'PaymentSource'         => 'DF',
                    'AuthCode'              => $authCode,
                    'TransactionAmount'     => $transactionAmount,
                    'AVSResponseCode'       => 0,
                    'OrderNumber'           => $donationId,
                    'IsApproved'            => 1,
                    'CVV2ResponseCode'      => 'M',
                    'ReturnCode'            => 100,
                    'TransactionFileName'   => $transactionFileName,
                    'ResponseHTML'          => 'Approved',
                    'TransactionTypeId'     => 1,
                    'InsertDate'        => $transactionDate->format('Y-m-d H:i:s'),
                    'UpdateDate'        => $transactionDate->format('Y-m-d H:i:s'),
                ));
            }
        }
 
        echo PHP_EOL;
    }
}