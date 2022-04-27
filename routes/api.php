<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Helper\FinancialProvideController;
use App\Http\Controllers\Helper\FoundController;
use App\Http\Controllers\Helper\ProvideJobContoller;
use App\Http\Controllers\Helper\SupportThindToBeDoneController;
use App\Http\Controllers\Needer\FinancialHelpController;
use App\Http\Controllers\Needer\LostController;
use App\Http\Controllers\Needer\NeedJobContoller;
use App\Http\Controllers\Needer\ThingsToBeDoneContoller;
use App\Http\Controllers\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Route::group(['middleware' => 'cors'], function () {

Route::post('/login', [Controller::class, 'login']);
Route::post('/sign-up', [Controller::class, 'registeration']);
Route::post('/forget-password', [Controller::class, 'forgetPassword']);
Route::post('/change-password-with-verification', [Controller::class, 'changePasswordWithVerification']);
Route::post('/contact-us', [Controller::class, 'contactUs']);

Route::group(['middleware' => 'CheckAuth:api-user'], function () {

    Route::post('/user', [Controller::class, 'me']);
    Route::post('/update-user-info', [Controller::class, 'updateUserInfo']);
    Route::post('/make-comment',[CommentController::class,'makeComment']);
    Route::post('/get-comments',[CommentController::class,'getComment']);

    Route::post('/get-lostes', [Controller::class, 'getLostess']);

    Route::group(['prefix' => 'needer'], function () {

        Route::post('/make-lost', [LostController::class, 'makeLost']);
        // Route::post('/get-all-my-lostes',[LostController::class,'getAllMyLostes']); dublicated with get lostes => personal = 1
        Route::post('/get-one-lost', [LostController::class, 'getOneLost']);
        Route::post('/update-lost', [LostController::class, 'updateLost']);
        Route::post('/delete-lost', [LostController::class, 'deleteLost']);

        Route::post('/create-need-jop-post', [NeedJobContoller::class, 'createNeedJopPost']);
        Route::get('/get-provide-jobs', [NeedJobContoller::class, 'getProvideJobs']);
        Route::post('/apply-to-provide-job', [NeedJobContoller::class, 'applyToProvideJob']);
        Route::post('/delete-need-job', [NeedJobContoller::class, 'deleteNeedJob']);
        Route::post('/update-need-job', [NeedJobContoller::class, 'updateNeedJob']);
        Route::get('/get-my-need-job', [NeedJobContoller::class, 'getMyNeedJob']);
        Route::post('/get-matches-for-need-job', [NeedJobContoller::class, 'getMatchesForNeedJob']);
        Route::post('/get-all-my-applying-for-provide-jobs', [NeedJobContoller::class, 'getAllMyApplyingForProvideJobs']);
        Route::post('/get-all-accept-my-applying-for-provide-jobs', [NeedJobContoller::class, 'getAllAcceptMyApplyingForProvideJobs']);

        Route::post('/insert-thing-to-be-done', [ThingsToBeDoneContoller::class, 'insertThingToBeDone']);
        Route::get('/get-all-supports-to-be-done', [ThingsToBeDoneContoller::class, 'getAllSupportsToBeDone']);
        Route::post('/apply-to-support-thing', [ThingsToBeDoneContoller::class, 'applyToSupportThing']);
        Route::post('/get-all-my-things-to-be-done', [ThingsToBeDoneContoller::class, 'getAllMyThingsToBeDone']);
        Route::post('/delete-thing-to-be-done', [ThingsToBeDoneContoller::class, 'deleteThingToBeDone']);
        Route::post('/get-thing-to-be-done', [ThingsToBeDoneContoller::class, 'getThingToBeDone']);
        Route::post('/update-thing-to-be-done', [ThingsToBeDoneContoller::class, 'updateThingToBeDone']);
        Route::post('/get-applyers-thing-to-be-done', [ThingsToBeDoneContoller::class, 'getApplyersThingToBeDone']);
        Route::post('/response-to-applyer-thing-to-be-done', [ThingsToBeDoneContoller::class, 'responseToApplyersThingToBeDone']);
        Route::post('/get-acceptance-for-thing-to-be-done', [ThingsToBeDoneContoller::class, 'getAcceptanceForThingToBeDone']);
        Route::post('/get-matches-for-thing-to-be-done', [ThingsToBeDoneContoller::class, 'getMatchesForThingToBeDone']);
    
        Route::post('/insert-need-money-help', [FinancialHelpController::class, 'insertNeedMoneyHelp']);
        Route::post('/get-all-my-need-money-posts', [FinancialHelpController::class, 'getAllMyNeedMoneyPosts']);
        Route::post('/get-one-need-money-post', [FinancialHelpController::class, 'getOneNeedMoneyPost']);
        Route::post('/update-need-money-post', [FinancialHelpController::class, 'updateNeedMoneyPost']);
        Route::post('/delete-need-money-post', [FinancialHelpController::class, 'deleteNeedMoneyPost']);
        Route::post('/get-applyers-to-need-money-post', [FinancialHelpController::class, 'getApplyersToNeedMoneyPost']);
        Route::post('/accept-applyer-to-need-money-post', [FinancialHelpController::class, 'acceptApplyersToNeedMoneyPost']);
        Route::post('/get-accept-applyer-to-help-money-post', [FinancialHelpController::class, 'getAcceptApplyerToHelpMoneyPost']);
    
        Route::post('/insert-post',[PostController::class,'insertPost']);
        Route::get('/get-all-posts',[PostController::class,'getAlltPosts']);
        Route::post('/get-only-my-posts',[PostController::class,'getOnlyMytPosts']);
        Route::post('/get-one-post',[PostController::class,'getOnePost']);
        Route::post('/update-post',[PostController::class,'updatePost']);
        Route::post('/delete-post',[PostController::class,'deletePost']);
        Route::post('/filter-posts',[PostController::class,'filterPosts']);
        Route::post('/filter-my-posts',[PostController::class,'filterMyPosts']);

      

    });

    Route::group(['prefix' => 'helper'], function () {

        Route::post('/make-found', [FoundController::class, 'makeFound']);
        Route::post('/get-all-my-founds', [FoundController::class, 'getAllMyFounds']);
        Route::post('/get-one-found', [FoundController::class, 'getoneFound']);
        Route::post('/update-found', [FoundController::class, 'updateFound']);
        Route::post('/delete-found', [FoundController::class, 'deleteFound']);
        Route::post('/get-matches-for-found', [FoundController::class, 'getMatchesForFound']); ## new
        
        Route::post('/create-provide-jop-post', [ProvideJobContoller::class, 'createProvideJopPost']);
        Route::get('/get-need-jobs', [ProvideJobContoller::class, 'getNeedJobs']);
        Route::get('/get-all-my-provide-jop-posts', [ProvideJobContoller::class, 'getAllMyProvideJopPosts']);
        Route::post('/get-provide-jop-applyers', [ProvideJobContoller::class, 'getProvideJopApplyers']);
        Route::post('/response-provide-jop-applyer', [ProvideJobContoller::class, 'responseProvideJopApplyer']);
        Route::post('/delete-provide-job', [ProvideJobContoller::class, 'deleteProvideJob']);
        Route::post('/update-provide-job', [ProvideJobContoller::class, 'updateProvideJob']);
        Route::post('/get-one-provide-job', [ProvideJobContoller::class, 'getOneProvideJob']);
        Route::post('/get-matches-for-provide-job', [ProvideJobContoller::class, 'getMatchesForProvideJob']);
        Route::post('/get-acceptance-for-provide-job', [ProvideJobContoller::class, 'getAcceptanceForProvideJob']);

        Route::post('/insert-support-thing-to-be-done', [SupportThindToBeDoneController::class, 'insertSupportThingToBeDone']);
        Route::get('/get-all-things-to-be-done', [SupportThindToBeDoneController::class, 'getAllThingsToBeDone']);
        Route::post('/apply-to-thing-to-done', [SupportThindToBeDoneController::class, 'applyToThingToDone']);

        Route::post('/get-support-all-my-things-to-be-done', [SupportThindToBeDoneController::class, 'getSupportAllMyThingsToBeDone']);
        Route::post('/delete-support-thing-to-be-done', [SupportThindToBeDoneController::class, 'deleteSupportThingToBeDone']);
        Route::post('/get-support-thing-to-be-done', [SupportThindToBeDoneController::class, 'getSupportThingToBeDone']);
        Route::post('/update-support-thing-to-be-done', [SupportThindToBeDoneController::class, 'updateSupportThingToBeDone']);
        Route::post('/get-support-applyers-thing-to-be-done', [SupportThindToBeDoneController::class, 'getSupportApplyersThingToBeDone']);
        Route::post('/response-to-applyer-support-thing-to-be-done', [SupportThindToBeDoneController::class, 'responseToApplyersSupportThingToBeDone']);
        Route::post('/get-matches-to-support-to-be-done', [SupportThindToBeDoneController::class, 'getMatchesToSupportToBeDone']);
        Route::post('/get-acceptance-to-support-to-be-done', [SupportThindToBeDoneController::class, 'getAcceptanceToSupportToBeDone']);

        Route::post('/get-all-financial-need',[FinancialProvideController::class,'getAllFinancialNeed']);
        Route::post('/provide-financial-help',[FinancialProvideController::class,'provideFinancialHelp']);
        Route::post('/get-all-my-provide-financial-helps',[FinancialProvideController::class,'getAllMyProvideFinancialHelps']);
        Route::post('/delete-my-provide-financial-help',[FinancialProvideController::class,'deleteAllMyProvideFinancialHelp']);

    });
});



############### web ###########################
Route::group(['prefix' => 'web'], function () {

    Route::post('/get-lostes', [Controller::class, 'getLostess']);
    Route::post('/get-user-info', [Controller::class, 'getUserInfo']);
    Route::post('/update-user-info', [Controller::class, 'updateUserInfo']);
    Route::post('/make-comment',[CommentController::class,'makeComment']);
    Route::post('/get-comments',[CommentController::class,'getComment']);
    
    Route::group(['prefix' => 'needer'], function () {

        Route::post('/make-lost', [LostController::class, 'makeLost']);
        Route::post('/get-one-lost', [LostController::class, 'getOneLost']);
        Route::post('/update-lost', [LostController::class, 'updateLost']);
        Route::post('/delete-lost', [LostController::class, 'deleteLost']);

        Route::post('/create-need-jop-post', [NeedJobContoller::class, 'createNeedJopPost']);
        Route::post('/get-provide-jobs', [NeedJobContoller::class, 'getProvideJobs']);
        Route::post('/apply-to-provide-job', [NeedJobContoller::class, 'applyToProvideJob']);
        Route::post('/delete-need-job', [NeedJobContoller::class, 'deleteNeedJob']);
        Route::post('/update-need-job', [NeedJobContoller::class, 'updateNeedJob']);
        Route::post('/get-my-need-job', [NeedJobContoller::class, 'getMyNeedJob']);
        Route::post('/get-matches-for-need-job', [NeedJobContoller::class, 'getMatchesForNeedJob']);
        Route::post('/get-all-my-applying-for-provide-jobs', [NeedJobContoller::class, 'getAllMyApplyingForProvideJobs']);
        Route::post('/get-all-accept-my-applying-for-provide-jobs', [NeedJobContoller::class, 'getAllAcceptMyApplyingForProvideJobs']);

        Route::post('/insert-thing-to-be-done', [ThingsToBeDoneContoller::class, 'insertThingToBeDone']);
        Route::post('/get-all-supports-to-be-done', [ThingsToBeDoneContoller::class, 'getAllSupportsToBeDone']);
        Route::post('/apply-to-support-thing', [ThingsToBeDoneContoller::class, 'applyToSupportThing']);
        Route::post('/delete-thing-to-be-done', [ThingsToBeDoneContoller::class, 'deleteThingToBeDone']);
        Route::post('/get-thing-to-be-done', [ThingsToBeDoneContoller::class, 'getThingToBeDone']);
        Route::post('/update-thing-to-be-done', [ThingsToBeDoneContoller::class, 'updateThingToBeDone']);
        Route::post('/get-all-my-things-to-be-done', [ThingsToBeDoneContoller::class, 'getAllMyThingsToBeDone']);
        Route::post('/get-applyers-thing-to-be-done', [ThingsToBeDoneContoller::class, 'getApplyersThingToBeDone']);
        Route::post('/response-to-applyer-thing-to-be-done', [ThingsToBeDoneContoller::class, 'responseToApplyersThingToBeDone']);
        Route::post('/get-acceptance-for-thing-to-be-done', [ThingsToBeDoneContoller::class, 'getAcceptanceForThingToBeDone']);
        Route::post('/get-matches-for-thing-to-be-done', [ThingsToBeDoneContoller::class, 'getMatchesForThingToBeDone']);
    
        Route::post('/insert-need-money-help', [FinancialHelpController::class, 'insertNeedMoneyHelp']);
        Route::post('/get-all-my-need-money-posts', [FinancialHelpController::class, 'getAllMyNeedMoneyPosts']);
        Route::post('/get-one-need-money-post', [FinancialHelpController::class, 'getOneNeedMoneyPost']);
        Route::post('/update-need-money-post', [FinancialHelpController::class, 'updateNeedMoneyPost']);
        Route::post('/delete-need-money-post', [FinancialHelpController::class, 'deleteNeedMoneyPost']);
        Route::post('/get-applyers-to-need-money-post', [FinancialHelpController::class, 'getApplyersToNeedMoneyPost']);
        Route::post('/accept-applyer-to-need-money-post', [FinancialHelpController::class, 'acceptApplyersToNeedMoneyPost']);    
        Route::post('/get-accept-applyer-to-help-money-post', [FinancialHelpController::class, 'getAcceptApplyerToHelpMoneyPost']);
    
        Route::post('/insert-post',[PostController::class,'insertPost']);
        Route::get('/get-all-posts',[PostController::class,'getAlltPosts']);
        Route::post('/get-only-my-posts',[PostController::class,'getOnlyMytPosts']);
        Route::post('/get-one-post',[PostController::class,'getOnePost']);
        Route::post('/update-post',[PostController::class,'updatePost']);
        Route::post('/delete-post',[PostController::class,'deletePost']);
        Route::post('/filter-posts',[PostController::class,'filterPosts']);
        Route::post('/filter-my-posts',[PostController::class,'filterMyPosts']);


    });

    Route::group(['prefix' => 'helper'], function () {

        Route::post('/make-found', [FoundController::class, 'makeFound']);
        Route::post('/get-all-my-founds', [FoundController::class, 'getAllMyFounds']);
        Route::post('/get-one-found', [FoundController::class, 'getoneFound']);
        Route::post('/update-found', [FoundController::class, 'updateFound']);
        Route::post('/delete-found', [FoundController::class, 'deleteFound']);
        Route::post('/get-matches-for-found', [FoundController::class, 'getMatchesForFound']); ## new
        
        Route::post('/create-provide-jop-post', [ProvideJobContoller::class, 'createProvideJopPost']);
        Route::get('/get-need-jobs', [ProvideJobContoller::class, 'getNeedJobs']);
        Route::post('/get-all-my-provide-jop-posts', [ProvideJobContoller::class, 'getAllMyProvideJopPosts']);
        Route::post('/get-provide-jop-applyers', [ProvideJobContoller::class, 'getProvideJopApplyers']);
        Route::post('/response-provide-jop-applyer', [ProvideJobContoller::class, 'responseProvideJopApplyer']);
        Route::post('/delete-provide-job', [ProvideJobContoller::class, 'deleteProvideJob']);
        Route::post('/update-provide-job', [ProvideJobContoller::class, 'updateProvideJob']);
        Route::post('/get-one-provide-job', [ProvideJobContoller::class, 'getOneProvideJob']);
        Route::post('/get-matches-for-provide-job', [ProvideJobContoller::class, 'getMatchesForProvideJob']);
        Route::post('/get-acceptance-for-provide-job', [ProvideJobContoller::class, 'getAcceptanceForProvideJob']);

        Route::post('/insert-support-thing-to-be-done', [SupportThindToBeDoneController::class, 'insertSupportThingToBeDone']);
        Route::post('/get-all-things-to-be-done', [SupportThindToBeDoneController::class, 'getAllThingsToBeDone']);
        Route::post('/apply-to-thing-to-done', [SupportThindToBeDoneController::class, 'applyToThingToDone']);

        Route::post('/get-support-all-my-things-to-be-done', [SupportThindToBeDoneController::class, 'getSupportAllMyThingsToBeDone']);
        Route::post('/delete-support-thing-to-be-done', [SupportThindToBeDoneController::class, 'deleteSupportThingToBeDone']);
        Route::post('/get-support-thing-to-be-done', [SupportThindToBeDoneController::class, 'getSupportThingToBeDone']);
        Route::post('/update-support-thing-to-be-done', [SupportThindToBeDoneController::class, 'updateSupportThingToBeDone']);
        Route::post('/get-support-applyers-thing-to-be-done', [SupportThindToBeDoneController::class, 'getSupportApplyersThingToBeDone']);
        Route::post('/response-to-applyer-support-thing-to-be-done', [SupportThindToBeDoneController::class, 'responseToApplyersSupportThingToBeDone']);
        Route::post('/get-matches-to-support-to-be-done', [SupportThindToBeDoneController::class, 'getMatchesToSupportToBeDone']);
        Route::post('/get-acceptance-to-support-to-be-done', [SupportThindToBeDoneController::class, 'getAcceptanceToSupportToBeDone']);
    
        Route::post('/get-all-financial-need',[FinancialProvideController::class,'getAllFinancialNeed']);
        Route::post('/provide-financial-help',[FinancialProvideController::class,'provideFinancialHelp']);
        Route::post('/get-all-my-provide-financial-helps',[FinancialProvideController::class,'getAllMyProvideFinancialHelps']);
        Route::post('/delete-my-provide-financial-help',[FinancialProvideController::class,'deleteAllMyProvideFinancialHelp']);
    
    });
});


// });
