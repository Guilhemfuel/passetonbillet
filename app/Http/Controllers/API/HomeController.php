<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\Content\HelpQuestionResource;
use App\Http\Resources\ReviewResource;
use App\Http\Resources\TicketRessource;
use App\Models\Content\HelpQuestion;
use App\Models\Review;
use App\Ticket;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    const RECENT_TICKETS = 'recent_tickets';
    const HELP_QUESTIONS = 'help_questions';
    const REVIEWS = 'reviews';

    const RESOURCES = [
        self::RECENT_TICKETS,
        self::HELP_QUESTIONS,
        self::REVIEWS
    ];

    /**
     * Return the required resource returned by the homepage
     *
     * @param $resource
     */
    public function getHomeResource($resource) {
        if (!in_array($resource,self::RESOURCES)) {
            return response([
                'error' => 'The resource specified is unknown.'
            ],400);
        }

        switch ($resource){
            case self::RECENT_TICKETS:
                return $this->getRecentTickets();
                break;
            case self::HELP_QUESTIONS:
                return $this->getHelpQuestions();
                break;
            case self::REVIEWS:
                return $this->getReviews();
                break;
        }
    }

    private function getRecentTickets() {
        $tickets = Ticket::getMostRecentTickets( 8 );
        return TicketRessource::collection( $tickets );
    }

    private function getHelpQuestions() {
        return HelpQuestionResource::collection( HelpQuestion::getCached( 4 ) );
    }

    private function getReviews() {
        $reviews = Review::getSelectedReviews( 3 );
        return ReviewResource::collection( $reviews );
    }
}
