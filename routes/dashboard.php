<?php

use App\Http\Controllers\backend\bounceController;
use App\Http\Controllers\backend\campaignController;
use App\Http\Controllers\backend\emailController;
use App\Http\Controllers\backend\emailListController;
use App\Http\Controllers\backend\pListController;
use App\Http\Controllers\backend\pNumberController;
use App\Http\Controllers\backend\senderVerificationController;
use App\Http\Controllers\backend\SingleSendController;
use App\Http\Controllers\backend\smsController;
use App\Http\Controllers\backend\spamController;
use App\Http\Controllers\backend\unsubscribeGroupsController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::view('/multiselect','layouts.multiselect');

Route::resource('/email',emailController::class);
Route::resource('/email_list',emailListController::class);
Route::post('/email_list/contact/{list_id}/remove/{email_id}', [emailListController::class, 'removeContactFromList'])->name('removeContactFromList');
Route::post('/email_list/contact/{email_id}/add/{list_id}', [emailListController::class, 'addContactToList'])->name('addContactToList');
Route::post('/get_sendgrid_id/{id}',[emailController::class, 'getSendgridId'])->name('email.getSendgridId');
Route::resource('/single-sends',SingleSendController::class);
Route::get('single-sends/view/mail/{mailId}',[SingleSendController::class , 'viewMail'])->name('viewMail');
Route::post('/single-sends/update/single-send/Schedule/set',[SingleSendController::class, 'updateSchedule'])->name('single-sends.updateSchedule');
Route::post('/single-sends/update/single-send/Schedule/cancel',[SingleSendController::class, 'cancelSchedule'])->name('single-sends.cancelSchedule');
Route::resource('/suppression-group/bounce',bounceController::class);
Route::get('/suppression-group/bounce/list/update', [bounceController::class, 'updateList'])->name('updateList');
Route::resource('/unsubscribe-group',unsubscribeGroupsController::class);
Route::post('/suppression-group/update-group/{groupId}', [unsubscribeGroupsController::class, 'updateGroup'])->name('updateGroup');
Route::get('/suppression-group/addEmailToSuppression', [unsubscribeGroupsController::class, 'addEmailToSuppression'])->name('addEmailToSuppression');
Route::delete('/unsubscribe-group/destroy/{emailInfo}/{group_id}', [unsubscribeGroupsController::class, 'deleteEmailFromUnsubscribeGroup'])->name('deleteEmailFromUnsubscribeGroup');
Route::resource('/sender-verification',senderVerificationController::class);
Route::resource('/spam', spamController::class);
Route::get('/spam/list/update',[spamController::class, 'updateSpamList'])->name('spam.updatelist');
Route::resource('/mail/campaign',campaignController::class);
///Route::get('/sender-verification/get-all-single-send',[senderVerificationController::class , 'getAllSingleSend'])->name('getAllSingleSend');



Route::get('/sms', [smsController::class,'index'])->name('sms');


//Route::resource('/contact/phone_number',pNumberController::class);
//Route::resource('/contact/phone_number/group',pListController::class);

Route::get('dashboard/contact/phone_number/group', [pListController::class,'index'])->name('group.index');
Route::post('/dashboard/contact/phone_number/group', [pListController::class,'store'])->name('group.store');
Route::get('/dashboard/contact/phone_number/group/create', [pListController::class,'create'])->name('group.create');
Route::get('/dashboard/contact/phone_number/group/{group}/edit', [pListController::class,'edit'])->name('group.edit');
Route::put('/dashboard/contact/phone_number/group/{group}', [pListController::class,'update'])->name('group.update');
Route::delete('/dashboard/contact/phone_number/group/{group}', [pListController::class,'destroy'])->name('group.destroy');


Route::get('dashboard/contact/phone_number', [pNumberController::class,'index'])->name('phone_number.index');
Route::post('dashboard/contact/phone_number', [pNumberController::class,'store'])->name('phone_number.store');
Route::get('dashboard/contact/phone_number/create', [pNumberController::class,'create'])->name('phone_number.create');
Route::get('dashboard/contact/phone_number/{info}', [pNumberController::class,'show'])->name('phone_number.show');
Route::get('dashboard/contact/phone_number/{info}/edit', [pNumberController::class,'edit'])->name('phone_number.edit');
Route::put('dashboard/contact/phone_number/{info}', [pNumberController::class,'update'])->name('phone_number.update');
Route::delete('dashboard/contact/phone_number/{info}', [pNumberController::class,'destroy'])->name('phone_number.destroy');
