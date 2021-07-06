


	<?php

    require_once("../action/DAO/Connection.php");
    require_once("../action/Tools/MailChimp.php");
    // use \DrewM\MailChimp\MailChimp;

    // require($_SERVER['DOCUMENT_ROOT'] . '/mailchimp/Mailchimp.php');    // You may have to modify the path based on your own configuration.

    /**
     * Access to all MailChimp related functions
     *
     * @link       https://kikicode.club/action/DAO/MailChimpDAO
     * @since      Class available since Alpha 1.0.0
     */

    use \DrewM\MailChimp\MailChimp;

    class MailChimpDAO
    {
        // use \DrewM\MailChimp\MailChimp;

        const API_KEY = "141ea65c047546265081e1a8fa9d65cc-us20";
        const LIST_ID = "6f050b123d";
        public static function addSubscriber($email, $firstname, $lastname)
        {


            $list_id = MailChimpDAO::LIST_ID;
            $MailChimp = new MailChimp(MailChimpDAO::API_KEY);

            $result = $MailChimp->post("lists/$list_id/members", [
                'email_address' => $email,
                'status'        => 'subscribed',
            ]);

            $subscriber_hash = MailChimp::subscriberHash($email);
            $resultName = $MailChimp->patch("lists/$list_id/members/$subscriber_hash", [
                'merge_fields' => ['FNAME' => $firstname, 'LNAME' => $lastname],
            ]);

            $resultTags = $MailChimp->post(
                "lists/$list_id/members/$subscriber_hash/tags",
                [
                    'tags' => [
                        [
                            'name' => 'Kikiclub',
                            'status' => 'active'
                        ]
                    ]
                ]
            );
        }

        // public function addSubscriber($email, $firstname, $lastname)
        // {


        //     $Mailchimp = new Mailchimp(MailChimpDAO::API_KEY);
        //     $Mailchimp_Lists = new Mailchimp_Lists($Mailchimp);
        //     try {
        //         $subscriber = $Mailchimp_Lists->subscribe(
        //             MailChimpDAO::LIST_ID,
        //             array('email' => $email), // Specify the e-mail address you want to add to the list.
        //             array('FNAME' => $firstname, 'LNAME' => $lastname), // Set the first name and last name for the new subscriber.
        //             'text', // Specify the e-mail message type: 'html' or 'text'
        //             FALSE, // Set double opt-in: If this is set to TRUE, the user receives a message to confirm they want to be added to the list.
        //             TRUE // Set update_existing: If this is set to TRUE, existing subscribers are updated in the list. If this is set to FALSE, trying to add an existing subscriber causes an error.
        //         );

        //         $hashed = md5($email);
        //         $payload = '{ "tags": [ { "name": "kikiclub", "status": "active" } ] }';
        //         $payload_json = json_decode($payload, true);
        //         $id = MailChimpDAO::LIST_ID;
        //         $result = $Mailchimp_Lists->post("lists/$id/members/$hashed/tags", $payload_json);
        //     } catch (Exception $e) {
        //     }
        // }

        public static function addAllSubscriber($users)
        {
            $list_id = MailChimpDAO::LIST_ID;
            $MailChimp = new MailChimp(MailChimpDAO::API_KEY);

            foreach ($users as $user) {
                $email = $user['email'];
                $firstname = $user['firstname'];
                $lastname = $user['lastname'];

                $result = $MailChimp->post("lists/$list_id/members", [
                    'email_address' => $email,
                    'status'        => 'subscribed',
                ]);

                $subscriber_hash = MailChimp::subscriberHash($email);
                $resultName = $MailChimp->patch("lists/$list_id/members/$subscriber_hash", [
                    'merge_fields' => ['FNAME' => $firstname, 'LNAME' => $lastname],
                ]);

                $resultTags = $MailChimp->post(
                    "lists/$list_id/members/$subscriber_hash/tags",
                    [
                        'tags' => [
                            [
                                'name' => 'Kikiclub',
                                'status' => 'active'
                            ]
                        ]
                    ]
                );
            }
        }
    }
