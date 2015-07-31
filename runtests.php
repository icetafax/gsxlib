<?php 

require_once('simpletest/autorun.php');
require_once('gsxlib.php');

class GsxlibTest extends UnitTestCase
{
    function setUp() {
        $this->sn = $_ENV['GSX_SN'];
        $this->gsx = GsxLib::getInstance($_ENV['GSX_SOLDTO'], $_ENV['GSX_USER'], 'ut');
    }

    function testWarranty() {
        $wty = $this->gsx->warrantyStatus($this->sn);
        $this->assertEqual($wty->warrantyStatus, 'Out Of Warranty (No Coverage)');
    }

    function testSymptomIssue() {
        $r = $this->gsx->fetchSymptomIssue($this->sn);
        $this->assertEqual($r->symptoms[0]->reportedSymptomCode, 6115);
        $this->assertEqual($r->symptoms[1]->reportedSymptomDesc, "Accidental damage");
    }

    function testCreateCarryInRepair() {
        $symptom = $this->gsx->fetchSymptomIssue($this->sn)->symptoms[0];

        $repairData = array(
            'shipTo' => '6191',
            'serialNumber' => $this->sn,
            'diagnosedByTechId' => 'USA022SN',
            'symptom' => 'Sample symptom',
            'diagnosis' => 'Sample diagnosis',
            'unitReceivedDate' => '07/25/15',
            'unitReceivedTime' => '12:40 PM',
            'notes' => 'A sample notes',
            'poNumber' => '11223344',
            'popFaxed' => false,
            'orderLines' => array(
                'partNumber' => '076-1080',
                'comptiaCode' => '660',
                'comptiaModifier' => 'A',
                'abused' => false
            ),
            'customerAddress' => array(
                'addressLine1' => 'Address line 1',
                'country' => 'US',
                'city' => 'Cupertino',
                'state' => 'CA',
                'street' => 'Valley Green Dr',
                'zipCode' => '95014',
                'regionCode' => '005',
                'companyName' => 'Apple Inc',
                'emailAddress' => 'test@example.com',
                'firstName' => 'Customer Firstname',
                'lastName' => 'Customer lastname',
                'primaryPhone' => '4088887766'
            ),
            'reportedSymptomCode' => $symptom->reportedSymptomCode,
            'reportedIssueCode' => 'IP025',
        );

        $this->gsx->createCarryinRepair($repairData);

    }

    function _testCreateMailInRepair() {
        $repairData = array(
            'shipTo' => '6191',
            'accidentalDamage' => false,
            'addressCosmeticDamage' => false,
            'comptia' => array(
                'comptiaCode' => 'X01',
                'comptiaModifier' => 'D',
                'comptiaGroup' => 1,
                'technicianNote' => 'sample technician notes'
            ),
            'requestReviewByApple' => false,
            'serialNumber' => 'RM6501PXU9C',
            'diagnosedByTechId' => 'USA022SN',
            'symptom' => 'Sample symptom',
            'diagnosis' => 'Sample diagnosis',
            'unitReceivedDate' => '07/02/13',
            'unitReceivedTime' => '12:40 PM',
            'notes' => 'A sample notes',
            'purchaseOrderNumber' => 'AB12345',
            'trackingNumber' => '12345',
            'shipper' => 'XDHL',
            'soldToContact' => 'Cupertino',
            'popFaxed' => false,
            'orderLines' => array(
                'partNumber' => '076-1080',
                'comptiaCode' => '660',
                'comptiaModifier' => 'A',
                'abused' => false
            ),
            'customerAddress' => array(
                'addressLine1' => 'Address line 1',
                'country' => 'US',
                'city' => 'Cupertino',
                'state' => 'CA',
                'street' => 'Valley Green Dr',
                'zipCode' => '95014',
                'regionCode' => '005',
                'companyName' => 'Apple Inc',
                'emailAddress' => 'test@example.com',
                'firstName' => 'Customer Firstname',
                'lastName' => 'Customer lastname',
                'primaryPhone' => '4088887766'
            ),
        );

        $this->gsx->createMailinRepair($repairData);

    }
}
