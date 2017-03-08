<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Mail;
use Session;
use Carbon\Carbon;
use App\Question;

class SiteController extends Controller
{
    public function getIndexPage(){
    	$articles = DB::table('articles')
       ->orderBy('created_at', 'desc')
       ->take(3)
       ->get();
       Carbon::setLocale('ru');
       foreach ($articles as $article) {
          $non_formatted_date = new Carbon($article->created_at);
          $date = $non_formatted_date->diffForHumans();
          $article->created_at = $date;
      }
      return view('index',[
          'articles' => $articles
          ]);
  }
  public function getAboutPage(){
   return view('pages.about');
}
public function getLawPage(){
    return view('pages.law');
}
public function getNewsPage(){
   $articles = DB::table('articles')
   ->where('published', '=', 1)
   ->orderBy('created_at', 'desc')
   ->paginate(9);
   Carbon::setLocale('ru');
    	/**
    	 * Make a human-readable date
    	 */
    	foreach ($articles as $article) {
    		$non_formatted_date = new Carbon($article->created_at);
    		$date = $non_formatted_date->format('j/m/Y');
    		$article->created_at = $date;
    	}
    	/**
    	 * 
    	 */
    	return view('pages.news',[
    		'articles' => $articles
    		]);
    }
    public function getArticle($id){
    	$article = DB::table('articles')
       ->where('id', $id)
       ->where('published', '1')
       ->first();
       Carbon::setLocale('ru');
       $non_formatted_date = new Carbon($article->created_at);
       $date = $non_formatted_date->format('j/m/Y');
       $article->created_at = $date;
       return view('pages.article',[
          'article' => $article
          ]);
   }
   public function getDepositPointsPage(){
    return view('pages.deposit-points');
   }
   public function getSellPointsPage(){
       return view('pages.sale-points');
   }
   public function getHowToRefillPage(){
       return view('pages.how_to_refill');
   }
   public function getHowToRefillSberbankPage(){
       return view('pages.how_to_refill_sberbank');
   }
    /**
     * CARDS
     */
    public function getEwalletPage(){
        $cards = DB::table('cards')
        ->where('type',1)
        ->get();
        return view('pages.ewallet',[
            'cards' => $cards
            ]);
    }
    public function getTravelCardsPage(){
        $cards = DB::table('cards')
        ->where('type',2)
        ->get();
        return view('pages.travel_cards',[
            'cards' => $cards
            ]);
    }
    public function getSbercardPage(){
        $cards = DB::table('cards')
        ->where('type',3)
        ->get();
        return view('pages.sbercard',[
            'cards' => $cards
            ]);
    }
    public function getCard($id){
        $card = DB::table('cards')
        ->where('id', $id)
        ->first();
        return view('pages.card',[
            'card' => $card
            ]);
    }
    public function getCardsPage(){
        $cards = DB::table('cards')
        ->get();
        return view('pages.cards',[
            'cards' => $cards
            ]);
    }
    /**
     * 
     */
    public function getContactsPage(){
        return view('pages.contacts');
    }

    public function getFaqPage(){
        $questions = DB::table('questions')
        ->where('answer', '!=', '')
        ->orderBy('updated_at')
        ->get();
        return view('pages.faq',[
            'questions' => $questions
            ]);
    }
    public function getAskPage(){
        return view('pages.ask');
    }
    public function postQuestion(Request $request){
        $this->validate($request,[
            'name' => 'required|min:1|max:100',
            'email' => 'required|min:1|max:100',
            'content' => 'required|min:1'
            ]);
        $name = $request['name'];
        $email = $request['email'];
        $content = $request['content'];
        /**
         * INSERT INTO DB
         * @var Question
         */
        $question = new Question;
        $question->name = $name;
        $question->email = $email;
        $question->content = $content;
        if ($question->save())
        {
            Mail::send('emails.question',
              ['name' => $name,
              'email' => $email,
              'content' => $content],
              function ($m){
                $m->from('activation@etk-club.ru', 'ETK21.RU');
                $m->to('questions@etk21.ru')->subject('Новый вопрос с сайта');
            });
            Session::flash('ok', 'Ваше сообщение отправлено');
            return redirect()->back();
        }
    }
}