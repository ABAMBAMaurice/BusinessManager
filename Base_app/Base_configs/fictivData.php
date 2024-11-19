<?php

        $customer = new Customer();
        $customer->Validate('No', 'CLT001');
        $customer->Validate('name', 'Tottem Business');
        $customer->Validate('first_name', 'BAMBA');
        $customer->Validate('last_name', 'Arnaud Maurice');
        $customer->Validate('address', '04 Blvd de Verdun');
        $customer->Validate('post_code', '35000');
        $customer->Validate('seller_register', 'CI-ABJ-2024-B-544512');
        $customer->Validate('tax_code', 'CC554120');
        $customer->Validate('email1', 'arnaud.bamba@tottem-business.com');
        $customer->Validate('email1', 'info@tottem-business.com');
        $customer->Validate('telephone_no1', '+225 0748786481');
        $customer->Validate('telephone_no2', '+33 6 61646915');
        $customer->Validate('pays_code', 'FR');
        $customer->Validate('ville_code', '35');
        $customer->Validate('password', '');
        $customer->Validate('grpe_cpta_marche', 'NATIONAL');
        $customer->Validate('grpe_cpta_client', 'NATIONAL');
        $customer->Insert();

        $customer2 = new Customer();
        $customer2->Validate('No', 'CLT002');
        $customer2->Validate('name', 'SOFRA');
        $customer2->Validate('first_name', 'POULLAIN');
        $customer2->Validate('last_name', 'Stéphane');
        $customer2->Validate('address', '12 rue de la cannebière');
        $customer2->Validate('post_code', '75018');
        $customer2->Validate('seller_register', 'FR-010102020303');
        $customer2->Validate('tax_code', 'FRCC554120');
        $customer2->Validate('email1', 's.poullain@sg.fr');
        $customer2->Validate('email1', 'info@sg.fr');
        $customer2->Validate('telephone_no1', '+33 9 45144123');
        $customer2->Validate('telephone_no2', '+33 6 61646915');
        $customer2->Validate('pays_code', 'FR');
        $customer2->Validate('ville_code', '75');
        $customer2->Validate('password', '');
        $customer2->Validate('grpe_cpta_marche', 'NATIONAL');
        $customer2->Validate('grpe_cpta_client', 'NATIONAL');
        $customer2->Insert();

        $customer3 = new Customer();
        $customer3->Validate('No', 'CLT003');
        $customer3->Validate('name', 'CIENERGIES');
        $customer3->Validate('first_name', 'ROMBA');
        $customer3->Validate('last_name', 'Ousséni');
        $customer3->Validate('address', 'Angré 7è tranche');
        $customer3->Validate('post_code', '00225');
        $customer3->Validate('seller_register', 'CI-ABJ-1960-B-2155458');
        $customer3->Validate('tax_code', 'CICC0123456789');
        $customer3->Validate('email1', 'Ousseni.romba@cinergies.ci');
        $customer3->Validate('email1', 'info@cienergies.ci');
        $customer3->Validate('telephone_no1', '+225 0774911620');
        $customer3->Validate('telephone_no2', '+225 2722414349');
        $customer3->Validate('pays_code', 'CI');
        $customer3->Validate('ville_code', 'ABJ');
        $customer3->Validate('password', '');
        $customer3->Validate('grpe_cpta_marche', 'NATIONAL');
        $customer3->Validate('grpe_cpta_client', 'NATIONAL');
        $customer3->Insert();

?>
