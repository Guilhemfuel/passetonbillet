<?php

namespace Tests\app\Http\Controllers;

use App\Http\Resources\TicketRessource;
use App\Models\Discussion;
use App\Notifications\MessageNotification;
use App\Notifications\OfferNotification;
use App\Ticket;
use App\Station;
use App\User;
use Carbon\Carbon;
use Laracasts\Flash\Flash;
use Laracasts\Flash\Message;
use Tests\LastarTestCase;
use Tests\TestCase;

class DiscussionControllerTest extends LastarTestCase
{

    public function testDenyOffer()
    {
        $discussion = factory( Discussion::class )->create( [
            'status' => Discussion::AWAITING
        ] );
        $this->be( $discussion->seller );
        $response = $this->postWithCsrf( route( 'public.message.offer.deny' ), [
            'discussion_id' => $discussion->id
        ] );
        $response->assertRedirect( route( 'public.message.home.page' ) );
        $discussion = $discussion->fresh();
        $this->assertEquals( $discussion->status, Discussion::DENIED );

    }

    public function testDenyOfferWrongUser()
    {
        // Fail if not right user
        $discussion = factory( Discussion::class )->create();
        $response = $this->beAUser()->postWithCsrf( route( 'public.message.offer.deny' ), [
            'discussion_id' => $discussion->id
        ] );
        $flashMesage = new Message();
        $flashMesage->important = true;
        $flashMesage->message = __( 'message.errors.wrong_user' );
        $flashMesage->level = 'danger';

        $response->assertRedirect( route( 'public.message.home.page' ) )
                 ->assertSessionHas( [ 'flash_notification' => collect( [ $flashMesage ] ) ] );
        $discussion = $discussion->fresh();
        $this->assertEquals( $discussion->status, Discussion::AWAITING );

    }

    public function testDenyOfferWrongStatus()
    {
        // Fail if not awaiting status
        $discussion = factory( Discussion::class )->create( [
            'status' =>  Discussion::DENIED
        ] );

        $flashMesage = new Message();
        $flashMesage->important = true;
        $flashMesage->message = __( 'message.errors.cant_accept' );
        $flashMesage->level = 'danger';
        $this->be( $discussion->seller );
        $response = $this->postWithCsrf( route( 'public.message.offer.deny' ), [
            'discussion_id' => $discussion->id
        ] );
        $response->assertRedirect( route( 'public.message.home.page' ) )
                 ->assertSessionHas( [ 'flash_notification' => collect( [ $flashMesage ] ) ] );
    }

    public function testDenyOfferDiscussionNotFound()
    {
        // Fail discussion deleted
        $discussion = factory( Discussion::class )->create();
        $discussionId = $discussion->id;
        $discussion->delete();

        $flashMesage = new Message();
        $flashMesage->important = true;
        $flashMesage->message = __( 'message.errors.not_found' );
        $flashMesage->level = 'danger';
        $this->be( $discussion->seller );
        $response = $this->postWithCsrf( route( 'public.message.offer.deny' ), [
            'discussion_id' => $discussionId
        ] );
        $response->assertRedirect( route( 'public.message.home.page' ) )
                 ->assertSessionHas( [ 'flash_notification' => collect( [ $flashMesage ] ) ] );
    }

    public function testAcceptOffer()
    {
        $discussion = factory( Discussion::class )->create();
        $this->be( $discussion->seller );
        $response = $this->postWithCsrf( route( 'public.message.offer.accept' ), [
            'discussion_id' => $discussion->id
        ] );
        $response->assertRedirect( route( 'public.message.home.page' ) );
        $discussion = $discussion->fresh();
        $this->assertEquals( $discussion->status, Discussion::ACCEPTED );

    }

    public function testAcceptOfferWrongUser()
    {
        // Fail if not right user
        $discussion = factory( Discussion::class )->create();
        $response = $this->beAUser()->postWithCsrf( route( 'public.message.offer.accept' ), [
            'discussion_id' => $discussion->id
        ] );
        $flashMesage = new Message();
        $flashMesage->important = true;
        $flashMesage->message = __( 'message.errors.wrong_user' );
        $flashMesage->level = 'danger';

        $response->assertRedirect( route( 'public.message.home.page' ) )
                 ->assertSessionHas( [ 'flash_notification' => collect( [ $flashMesage ] ) ] );
        $discussion = $discussion->fresh();
        $this->assertEquals( $discussion->status, Discussion::AWAITING );

    }

    public function testAcceptOfferWrongStatus()
    {
        // Fail if not awaiting status
        $discussion = factory( Discussion::class )->create( [
            'status' =>  Discussion::DENIED
        ] );

        $flashMesage = new Message();
        $flashMesage->important = true;
        $flashMesage->message = __( 'message.errors.cant_accept' );
        $flashMesage->level = 'danger';
        $this->be( $discussion->seller );
        $response = $this->postWithCsrf( route( 'public.message.offer.accept' ), [
            'discussion_id' => $discussion->id
        ] );
        $response->assertRedirect( route( 'public.message.home.page' ) )
                 ->assertSessionHas( [ 'flash_notification' => collect( [ $flashMesage ] ) ] );
    }

    public function testAcceptOfferDiscussionNotFound()
    {
        // Fail discussion deleted
        $discussion = factory( Discussion::class )->create();
        $discussionId = $discussion->id;
        $discussion->delete();

        $flashMesage = new Message();
        $flashMesage->important = true;
        $flashMesage->message = __( 'message.errors.not_found' );
        $flashMesage->level = 'danger';
        $this->be( $discussion->seller );
        $response = $this->postWithCsrf( route( 'public.message.offer.accept' ), [
            'discussion_id' => $discussionId
        ] );
        $response->assertRedirect( route( 'public.message.home.page' ) )
                 ->assertSessionHas( [ 'flash_notification' => collect( [ $flashMesage ] ) ] );
    }

    public function checkDiscussionActiveDataProvider()
    {
        $this->setUp();

        $data = [];

        // We make a couple discussion / ticket / user for each possible error
        //--------------------------
        // Mismatch discussion ticket
        $ticket = factory( Ticket::class )->create();
        $discussion = factory( Discussion::class )->create();

        array_push( $data, [
            $ticket,
            $discussion,
            $discussion->seller,
            false
        ] );

        // Mismatch user
        $ticket = factory( Ticket::class )->create();
        $discussion = factory( Discussion::class )->create( [
            'ticket_id' => $ticket->id
        ] );
        $user = factory( User::class )->create();

        array_push( $data, [
            $ticket,
            $discussion,
            $user,
            false
        ] );

        // Wrong discussion status
        $ticket = factory( Ticket::class )->create();
        $discussion = factory( Discussion::class )->create( [
            'ticket_id' => $ticket->id,
            'status'    => Discussion::AWAITING
        ] );

        array_push( $data, [
            $ticket,
            $discussion,
            $discussion->seller,
            false
        ] );

        // Should work - seller
        $discussion = factory( Discussion::class )->create([
            'status' => Discussion::ACCEPTED
        ]);

        array_push( $data, [
            $discussion->ticket,
            $discussion,
            $discussion->seller,
            true
        ] );

        // Should work - buyer
        $discussion = factory( Discussion::class )->create([
            'status' => Discussion::ACCEPTED
        ]);

        array_push( $data, [
            $discussion->ticket,
            $discussion,
            $discussion->buyer,
            true
        ] );

        return $data;
    }

    /**
     * Make sure that checkIfDiscussionActive filters out inactive discussion
     * Tested on get discussion only even if used in some other methods
     *
     * @dataProvider checkDiscussionActiveDataProvider
     */
    public function testCheckIfDiscussionActive( $ticket, $discussion, $user, $success )
    {
        $this->be( $user );
        $response = $this->get( route( 'public.message.discussion.page' , [$ticket->id,$discussion->id]) );
        if ($success){
            $response->assertSuccessful();
        } else {
            $response->assertRedirect( route( 'public.message.home.page' ) );
        }
    }

    public function testGetDiscussionTicketNotFound()
    {
        $discussion = factory( Discussion::class )->create();
        $ticket_id = $discussion->ticket->id;
        $discussion->ticket->delete();

        $this->be($discussion->seller);
        $response = $this->get( route( 'public.message.discussion.page' , [$ticket_id,$discussion->id]) );
        $response->assertRedirect( route( 'public.message.home.page' ) );
    }

    public function testGetDiscussionDiscussionNotFound()
    {
        $discussion = factory( Discussion::class )->create();
        $ticket = $discussion->ticket;
        $discussion_id = $discussion->id;
        $discussion->delete();

        $this->be($discussion->seller);
        $response = $this->get( route( 'public.message.discussion.page' , [$ticket->id,$discussion_id]) );
        $response->assertRedirect( route( 'public.message.home.page' ) );
    }

    public function testGetDiscussion()
    {
        $discussion = factory( Discussion::class )->create([
            'status' => Discussion::ACCEPTED
        ]);

        $this->be($discussion->seller);
        $response = $this->get( route( 'public.message.discussion.page' , [$discussion->ticket->id,$discussion->id]) );
        $response->assertSuccessful();

        $this->be($discussion->buyer);
        $response = $this->get( route( 'public.message.discussion.page' , [$discussion->ticket->id,$discussion->id]) );
        $response->assertSuccessful();
    }

    public function testSendMessageWithoutMessage()
    {
        $discussion = factory( Discussion::class )->create([
            'status' => Discussion::ACCEPTED
        ]);

        $this->be($discussion->seller);
        $response = $this->postWithCsrf(route('api.discussion.send',[
            $discussion->ticket_id,
            $discussion->id])
        );
        $response->assertRedirect();
    }

    public function testSendMessage()
    {
        \Notification::fake();

        $message = str_random(100);
        $discussion = factory( Discussion::class )->create([
            'status' => Discussion::ACCEPTED
        ]);

        $this->be($discussion->seller);
        $response = $this->postWithCsrf(route('api.discussion.send',[
            $discussion->ticket_id,
            $discussion->id]),[
                'message' => $message
        ]);
        $response->assertSuccessful();

        $this->assertDatabaseHas('messages',[
           'sender_id' =>  $discussion->seller->id,
           'message' => $message,
           'discussion_id' => $discussion->id
        ]);

        \Notification::assertSentTo(
            $discussion->buyer,
            MessageNotification::class,
            function ($notification) use ($discussion) {
                return $notification->discussion->id === $discussion->id;
            }
        );

        $this->be($discussion->buyer);
        $response = $this->postWithCsrf(route('api.discussion.send',[
            $discussion->ticket_id,
            $discussion->id]),[
            'message' => $message
        ]);
        $response->assertSuccessful();

        $this->assertDatabaseHas('messages',[
            'sender_id' =>  $discussion->buyer->id,
            'message' => $message,
            'discussion_id' => $discussion->id
        ]);

        \Notification::assertSentTo(
            $discussion->seller,
            MessageNotification::class,
            function ($notification) use ($discussion) {
                return $notification->discussion->id === $discussion->id;
            }
        );
    }

    public function testRefreshDiscussion(){
        $discussion = factory( Discussion::class )->create([
            'status' => Discussion::ACCEPTED
        ]);

        // Fill a bit the discussion
        for ($i=0;$i<5;$i++) {
            $this->be($discussion->seller);
            $this->postWithCsrf( route( 'api.discussion.send', [
                $discussion->ticket_id,
                $discussion->id
            ] ), [
                'message' => str_random()
            ] );
            $this->be($discussion->buyer);
            $this->postWithCsrf( route( 'api.discussion.send', [
                $discussion->ticket_id,
                $discussion->id
            ] ), [
                'message' => str_random()
            ] );
        }

        // Now we send two messages, and ask for a refresh after the first one
        $this->be($discussion->seller);
        $response = $this->postWithCsrf( route( 'api.discussion.send', [
            $discussion->ticket_id,
            $discussion->id
        ] ), [
            'message' => str_random()
        ] );

        $messageTime = \GuzzleHttp\json_decode($response->content())->data->created_at->date;
        $messageTime = new Carbon($messageTime);

        $response = $this->postWithCsrf( route( 'api.discussion.send', [
            $discussion->ticket_id,
            $discussion->id
        ] ), [
            'message' => str_random()
        ] );

        $message = \GuzzleHttp\json_decode( $response->content() )->data;

        // Now we make sure buyer can refresh
        $this->be($discussion->buyer);
        $url = route( 'api.discussion.refresh', [
                $discussion->ticket_id,
                $discussion->id
            ] ).'?date='.urlencode($messageTime->format('Y-m-d H:i:s'));
        $response = $this->get( $url);

        $refreshMessage = \GuzzleHttp\json_decode($response->content())->data[0];

        $this->assertEquals($refreshMessage->id, $message->id);

    }
}
