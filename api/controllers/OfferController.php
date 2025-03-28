<?php

require_once('../models/Offer.php');

class OfferController {
    private $offerModel;

    public function __construct($pdo) {
        $this->offerModel = new Offer($pdo);
    }

    public function getAllOffers() {
        return $this->offerModel->getAllOffers();
    }

    public function getOfferById($id) {
        return $this->offerModel->getOfferById($id);
    }

    public function getOffersWithCompetencies() {
        return $this->offerModel->getOffersWithCompetencies();
    }

    public function countOffers() {
        return $this->offerModel->countOffers();
    }
    
    public function getRecentOffers() {
        return $this->offerModel->getRecentOffers();
    }

    public function getWishlistStatistics() {
        return $this->offerModel->getWishlistStatistics();
    }

    public function getOffersByDuration() {
        return $this->offerModel->getOffersByDuration();
    }

    public function getWishlistByUserId($userId) {
        return $this->offerModel->getWishlistByUserId($userId);
    }
}
?>