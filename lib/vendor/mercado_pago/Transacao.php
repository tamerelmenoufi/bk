<?php

    // include('classes.php');

    // $PIX = new MercadoPago;
    // $retorno = $PIX->Transacao('{
    //     "transaction_amount": 10.00,
    //     "description": "Combo Da Felicidade",
    //     "payment_method_id": "pix",
    //     "payer": {
    //       "email": "tamer.menoufi@gmail.com",
    //       "first_name": "Tamer",
    //       "last_name": "Elmenoufi",
    //       "identification": {
    //           "type": "CPF",
    //           "number": "60110970225"
    //       },
    //       "address": {
    //           "zip_code": "69010110",
    //           "street_name": "Rua Monsehor Coutinho",
    //           "street_number": "600",
    //           "neighborhood": "Centro",
    //           "city": "Manaus",
    //           "federal_unit": "AM"
    //       }
    //     }
    //   }');


    //   $dados = json_decode($retorno);

    //   print_r($dados);



    //stdClass Object ( [id] => 21858831789 [date_created] => 2022-04-25T12:02:48.693-04:00 [date_approved] => [date_last_updated] => 2022-04-25T12:02:48.693-04:00 [date_of_expiration] => 2022-04-26T12:02:48.466-04:00 [money_release_date] => [operation_type] => regular_payment [issuer_id] => [payment_method_id] => pix [payment_type_id] => bank_transfer [status] => pending [status_detail] => pending_waiting_transfer [currency_id] => BRL [description] => Combo Da Felicidade [live_mode] => 1 [sponsor_id] => [authorization_code] => [money_release_schema] => [taxes_amount] => 0 [counter_currency] => [brand_id] => [shipping_amount] => 0 [pos_id] => [store_id] => [integrator_id] => [platform_id] => [corporation_id] => [collector_id] => 182791413 [payer] => stdClass Object ( [type] => [id] => 1112517280 [operator_id] => [email] => tamer.menoufi@gmail.com [identification] => stdClass Object ( [type] => CPF [number] => 60110970225 ) [phone] => stdClass Object ( [area_code] => [number] => [extension] => ) [first_name] => [last_name] => [entity_type] => ) [marketplace_owner] => [metadata] => stdClass Object ( ) [additional_info] => stdClass Object ( [available_balance] => [nsu_processadora] => [authentication_code] => ) [order] => stdClass Object ( ) [external_reference] => [transaction_amount] => 100 [transaction_amount_refunded] => 0 [coupon_amount] => 0 [differential_pricing_id] => [deduction_schema] => [callback_url] => [installments] => 1 [transaction_details] => stdClass Object ( [payment_method_reference_id] => [net_received_amount] => 0 [total_paid_amount] => 100 [overpaid_amount] => 0 [external_resource_url] => [installment_amount] => 0 [financial_institution] => [payable_deferral_period] => [acquirer_reference] => [bank_transfer_id] => [transaction_id] => ) [fee_details] => Array ( ) [charges_details] => Array ( ) [captured] => 1 [binary_mode] => [call_for_authorize_id] => [statement_descriptor] => [card] => stdClass Object ( ) [notification_url] => [refunds] => Array ( ) [processing_mode] => aggregator [merchant_account_id] => [merchant_number] => [acquirer_reconciliation] => Array ( ) [point_of_interaction] => stdClass Object ( [type] => OPENPLATFORM [business_info] => stdClass Object ( [unit] => online_payments [sub_unit] => default ) [location] => stdClass Object ( [state_id] => [source] => ) [application_data] => stdClass Object ( [name] => [version] => ) [transaction_data] => stdClass Object ( [qr_code] => 00020126580014br.gov.bcb.pix0136ee1cf67c-df46-49e0-8e44-4cdf68af94ad5204000053039865406100.005802BR5921TAMERMOHAMEDELMENOUFI6006Manaus62240520mpqrinter21858831789630422E8 [bank_transfer_id] => [transaction_id] => [financial_institution] => [ticket_url] => https://www.mercadopago.com.br/payments/21858831789/ticket?caller_id=1112517280&hash=1521606e-c77a-4fb3-81f8-293214cc0534 [bank_info] => stdClass Object ( [payer] => stdClass Object ( [account_id] => [id] => [long_name] => [external_account_id] => ) [collector] => stdClass Object ( [account_id] => [long_name] => [account_holder_name] => Tamir Mohamed el Menoufi [transfer_account_id] => ) [is_same_bank_account_owner] => [origin_bank_id] => [origin_wallet_id] => ) [qr_code_base64] => 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 ) ) )
    //stdClass Object ( [id] => 21859077973 [date_created] => 2022-04-25T12:12:12.658-04:00 [date_approved] => [date_last_updated] => 2022-04-25T12:12:12.658-04:00 [date_of_expiration] => 2022-04-26T12:12:12.450-04:00 [money_release_date] => [operation_type] => regular_payment [issuer_id] => [payment_method_id] => pix [payment_type_id] => bank_transfer [status] => pending [status_detail] => pending_waiting_transfer [currency_id] => BRL [description] => Combo Da Felicidade [live_mode] => 1 [sponsor_id] => [authorization_code] => [money_release_schema] => [taxes_amount] => 0 [counter_currency] => [brand_id] => [shipping_amount] => 0 [pos_id] => [store_id] => [integrator_id] => [platform_id] => [corporation_id] => [collector_id] => 182791413 [payer] => stdClass Object ( [type] => [id] => 1112517280 [operator_id] => [email] => tamer.menoufi@gmail.com [identification] => stdClass Object ( [type] => CPF [number] => 60110970225 ) [phone] => stdClass Object ( [area_code] => [number] => [extension] => ) [first_name] => [last_name] => [entity_type] => ) [marketplace_owner] => [metadata] => stdClass Object ( ) [additional_info] => stdClass Object ( [available_balance] => [nsu_processadora] => [authentication_code] => ) [order] => stdClass Object ( ) [external_reference] => [transaction_amount] => 10 [transaction_amount_refunded] => 0 [coupon_amount] => 0 [differential_pricing_id] => [deduction_schema] => [callback_url] => [installments] => 1 [transaction_details] => stdClass Object ( [payment_method_reference_id] => [net_received_amount] => 0 [total_paid_amount] => 10 [overpaid_amount] => 0 [external_resource_url] => [installment_amount] => 0 [financial_institution] => [payable_deferral_period] => [acquirer_reference] => [bank_transfer_id] => [transaction_id] => ) [fee_details] => Array ( ) [charges_details] => Array ( ) [captured] => 1 [binary_mode] => [call_for_authorize_id] => [statement_descriptor] => [card] => stdClass Object ( ) [notification_url] => [refunds] => Array ( ) [processing_mode] => aggregator [merchant_account_id] => [merchant_number] => [acquirer_reconciliation] => Array ( ) [point_of_interaction] => stdClass Object ( [type] => OPENPLATFORM [business_info] => stdClass Object ( [unit] => online_payments [sub_unit] => default ) [location] => stdClass Object ( [state_id] => [source] => ) [application_data] => stdClass Object ( [name] => [version] => ) [transaction_data] => stdClass Object ( [qr_code] => 00020126580014br.gov.bcb.pix0136ee1cf67c-df46-49e0-8e44-4cdf68af94ad520400005303986540510.005802BR5921TAMERMOHAMEDELMENOUFI6006Manaus62240520mpqrinter218590779736304A7A2 [bank_transfer_id] => [transaction_id] => [financial_institution] => [ticket_url] => https://www.mercadopago.com.br/payments/21859077973/ticket?caller_id=1112517280&hash=fee7b1fe-80af-4f36-97ef-c6caee77633c [bank_info] => stdClass Object ( [payer] => stdClass Object ( [account_id] => [id] => [long_name] => [external_account_id] => ) [collector] => stdClass Object ( [account_id] => [long_name] => [account_holder_name] => Tamir Mohamed el Menoufi [transfer_account_id] => ) [is_same_bank_account_owner] => [origin_bank_id] => [origin_wallet_id] => ) [qr_code_base64] => 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 ) ) )

echo "<img style='width:300px;' src = 'data:image/jpeg;base64,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' />";
