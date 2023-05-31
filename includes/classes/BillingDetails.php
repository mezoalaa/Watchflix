<?php
class BillingDetails {

    public static function insertDetails($con, $agreement, $token, $email) {
        $query = $con->prepare("INSERT INTO billingDetails (agreementId, nextBillingDate, token, email)
                                VALUES(:agreementId, :nextBillingDate, :token, :email)");
        $agreementDetails = $agreement->getAgreementDetails();

        $query->bindValue(":agreementId", $agreement->getId());
        $query->bindValue(":nextBillingDate", $agreementDetails->getNextBillingDate());
        $query->bindValue(":token", $token);
        $query->bindValue(":email", $email);

        return $query->execute();
    }

}
?>