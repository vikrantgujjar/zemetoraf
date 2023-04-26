<?php
Class Iyzipay extends Aj {
    public function createsession(){
        global $db,$config,$_LIBS;
        $iyzipay_payment = $config->iyzipay_payment;
        $iyzipay_mode = $config->iyzipay_mode;
        $iyzipay_key = $config->iyzipay_key;
        $iyzipay_buyer_id = $config->iyzipay_buyer_id;
        $iyzipay_secret_key = $config->iyzipay_secret_key;
        $iyzipay_buyer_name = $config->iyzipay_buyer_name;
        $iyzipay_buyer_surname = $config->iyzipay_buyer_surname;
        $iyzipay_buyer_gsm_number = $config->iyzipay_buyer_gsm_number;
        $iyzipay_buyer_email = $config->iyzipay_buyer_email;
        $iyzipay_identity_number = $config->iyzipay_identity_number;
        $iyzipay_city = $config->iyzipay_city;
        $iyzipay_zip = $config->iyzipay_zip;
        if ($iyzipay_payment !== 'yes' || self::ActiveUser() == NULL) {
            return array(
                'status' => 403,
                'message' => __('Forbidden')
            );
        }
        if (empty($_POST[ 'description' ])) {
            return array(
                'status' => 400,
                'message' => __('No description')
            );
        }
        if (empty($_POST[ 'payType' ])) {
            return array(
                'status' => 400,
                'message' => __('No payType')
            );
        }

        //
        if(file_exists($_LIBS . "iyzipay/samples/config.php")){
            require_once($_LIBS . "iyzipay/samples/config.php");
        }else{
            return array(
                'status' => 300,
                'message' => __('unknown_error')
            );
        }

        $response    = array();
        $product     = Secure($_POST[ 'description' ]);
        $realprice   = (int)Secure($_POST[ 'price' ]);
        $price       = (int)Secure($_POST[ 'price' ]) * 100;
        $amount      = 0;
        $membershipType      = 0;
        $currency    = self::Config()->iyzipay_currency;
        $payType     = Secure($_POST[ 'payType' ]);

        if ($payType == 'credits') {
            if ($realprice == self::Config()->bag_of_credits_price) {
                $amount = self::Config()->bag_of_credits_amount;
            } else if ($realprice == self::Config()->box_of_credits_price) {
                $amount = self::Config()->box_of_credits_amount;
            } else if ($realprice == self::Config()->chest_of_credits_price) {
                $amount = self::Config()->chest_of_credits_amount;
            }
        } else if ($payType == 'membership') {
            if ($realprice == self::Config()->weekly_pro_plan) {
                $membershipType = 1;
            } else if ($realprice == self::Config()->monthly_pro_plan) {
                $membershipType = 2;
            } else if ($realprice == self::Config()->yearly_pro_plan) {
                $membershipType = 3;
            } else if ($realprice == self::Config()->lifetime_pro_plan) {
                $membershipType = 4;
            }
            $amount = $price;
        } else if ($payType == 'unlock_private_photo') {
            if ((int)$realprice == (int)self::Config()->lock_private_photo_fee) {
                $amount = (int)self::Config()->lock_private_photo_fee;
            }
        } else if ($payType == 'lock_pro_video'){
            $amount = (int)self::Config()->lock_pro_video_fee;
        }
        if (!empty(self::Config()->currency_array) && in_array(self::Config()->iyzipay_currency, self::Config()->currency_array) && self::Config()->iyzipay_currency != self::Config()->currency && !empty(self::Config()->exchange) && !empty(self::Config()->exchange[self::Config()->iyzipay_currency])) {
            $realprice = (int)(($realprice * self::Config()->exchange[self::Config()->iyzipay_currency]));
        }

        $payload = [
            'userid'            => self::ActiveUser()->id,
            'description'       => $product,
            'realprice'         => $realprice,
            'price'             => $price,
            'amount'            => $amount,
            'payType'           => $payType,
            'membershipType'    => $membershipType,
            'currency'          => $currency
        ];

        $hash = base64_encode(serialize($payload));
        $callback_url = SeoUri('aj/iyzipay/success?hash='.$hash);
    
        $request->setPrice($realprice);
        $request->setPaidPrice($realprice);
        $request->setCallbackUrl($callback_url);
        
        $basketItems = array();
        $firstBasketItem = new \Iyzipay\Model\BasketItem();
        $firstBasketItem->setId("BI".rand(11111111,99999999));
        $firstBasketItem->setName($product);
        $firstBasketItem->setCategory1($product);
        $firstBasketItem->setItemType(\Iyzipay\Model\BasketItemType::PHYSICAL);
        $firstBasketItem->setPrice($realprice);
        $basketItems[0] = $firstBasketItem;
        $request->setBasketItems($basketItems);
        $checkoutFormInitialize = \Iyzipay\Model\CheckoutFormInitialize::create($request, IyzipayConfig::options());
        $content = $checkoutFormInitialize->getCheckoutFormContent();
        if (!empty($content)) {
            $db->where('id',self::ActiveUser()->id)->update('users',array('conversation_id' => $ConversationId));
            $response['html'] = $content;
            $response['status'] = 200;
        }
        else{
            $response['message'] = __('unknown_error');
            $response['status'] = 400;
        }
        return $response;
    }

    public function success(){
        global $db,$config,$_LIBS;
        $iyzipay_payment = $config->iyzipay_payment;

        if ($iyzipay_payment !== 'yes' || self::ActiveUser() == NULL) {
            return array(
                'status' => 403,
                'message' => __('Forbidden')
            );
        }
        if (empty($_GET[ 'hash' ]) || ( empty($_POST['token']) && empty(self::ActiveUser()->conversation_id) ) ) {
            return array(
                'status' => 400,
                'message' => __('No hash')
            );
        }
        require_once($_LIBS . "iyzipay/samples/config.php");

        $data           = unserialize(base64_decode(Secure($_GET[ 'hash' ])));
        $description    = $data['description'];
        $realprice      = $data['realprice'];
        $price          = $data['price'];
        $amount         = $data['amount'];
        $payType        = $data['payType'];
        $membershipType = $data['membershipType'];
        $currency       = $data['currency'];
        $user           = $db->objectBuilder()->where('id', self::ActiveUser()->id)->getOne('users', array('balance'));

        # create request class
		$_request = new \Iyzipay\Request\RetrieveCheckoutFormRequest();
		$_request->setLocale(\Iyzipay\Model\Locale::TR);
		$_request->setConversationId(self::ActiveUser()->conversation_id);
		$_request->setToken(Secure($_POST['token']));

		# make request
		$checkoutForm = \Iyzipay\Model\CheckoutForm::retrieve($_request, IyzipayConfig::options());

        if ($checkoutForm->getPaymentStatus() == 'SUCCESS') {

            if ($payType == 'credits') {
                //done
                $newbalance = $user->balance + $amount;
                $updated    = $db->where('id', self::ActiveUser()->id)->update('users', array('balance' => $newbalance));
                if ($updated) {
                    RegisterAffRevenue(self::ActiveUser()->id,$price / 100);
                    $db->insert('payments', array(
                        'user_id' => self::ActiveUser()->id,
                        'amount' => $price / 100,
                        'type' => 'CREDITS',
                        'pro_plan' => '0',
                        'credit_amount' => $amount,
                        'via' => 'iyzipay'
                    ));
                    $_SESSION[ 'userEdited' ] = true;
                    $response[ 'credit_amount' ]  = (int) $newbalance;
                    $url = $config->uri . '/ProSuccess';
                    if (!empty($_COOKIE['redirect_page'])) {
                        $redirect_page = preg_replace('/on[^<>=]+=[^<>]*/m', '', $_COOKIE['redirect_page']);
                        $url = preg_replace('/\((.*?)\)/m', '', $redirect_page);
                    }
                    header('Location: ' . $url);
                } else {
                    exit(__('Error While update balance after charging'));
                }
            } else if ($payType == 'membership') {
                //done
                $protime                = time();
                $is_pro                 = "1";
                $pro_type               = $membershipType;
                $updated                = $db->where('id', self::ActiveUser()->id)->update('users', array(
                    'pro_time' => $protime,
                    'is_pro' => $is_pro,
                    'pro_type' => $pro_type
                ));
                if ($updated) {
                    RegisterAffRevenue(self::ActiveUser()->id,$price / 100);
                    $db->insert('payments', array(
                        'user_id' => self::ActiveUser()->id,
                        'amount' => $price / 100,
                        'type' => 'PRO',
                        'pro_plan' => $membershipType,
                        'credit_amount' => '0',
                        'via' => 'iyzipay'
                    ));
                    $_SESSION[ 'userEdited' ] = true;
                    SuperCache::cache('pro_users')->destroy();
                } else {
                    exit(__('Error While make you pro'));
                }
                header('Location: ' . self::Config()->uri . '/ProSuccess?paymode=pro');
            } else if ($payType == 'unlock_private_photo') {
                //done
                $updated    = $db->where('id', self::ActiveUser()->id)->update('users', array('lock_private_photo' => 0));
                if ($updated) {
                    $db->insert('payments', array(
                        'user_id' => self::ActiveUser()->id,
                        'amount' => $price /100,
                        'type' => 'unlock_private_photo',
                        'pro_plan' => '0',
                        'credit_amount' => '0',
                        'via' => 'iyzipay'
                    ));
                    $_SESSION[ 'userEdited' ] = true;
                    header('Location: ' . self::Config()->uri . '/ProSuccess?paymode=unlock');
                    exit();
                } else {
                    exit(__('Error While update Unlock private photo charging'));
                }
            } else if ($payType == 'lock_pro_video') {
                //done
                $updated    = $db->where('id', self::ActiveUser()->id)->update('users', array('lock_pro_video' => 0));
                if ($updated) {
                    $db->insert('payments', array(
                        'user_id' => self::ActiveUser()->id,
                        'amount' => $price /100,
                        'type' => 'lock_pro_video',
                        'pro_plan' => '0',
                        'credit_amount' => '0',
                        'via' => 'iyzipay'
                    ));
                    $_SESSION[ 'userEdited' ] = true;
                    header('Location: ' . self::Config()->uri . '/ProSuccess?paymode=unlock');
                    exit();
                } else {
                    exit(__('Error While update Unlock private photo charging'));
                }
            }

        } else {
            header('Location: ' . SeoUri(''));
        }
        exit();
    }
}