@extends('layouts.app')
@section('content')
<div class="contact_panel">
  <div class="container">
    <div class="row">
        <div class="col-md-4">
            <div class="contact_box">
                <h3><i class="fa fa-pin"></i> Location</h3>
                <div class="contact_form">
                    <div class="address_box">
                        <h4>Head Office:</h4>
                        <p>Unigas Limited <br/>Gulshan C/A, Dhaka 1000, Dummy<br/>Bangladesh, Post Box: 3301 </p>
                    </div>
                    <div class="address_box">
                        <h4>Corporate Office:</h4>
                        <p>205-207, Tejgaon I/A, Dhaka 1208<br/>Tel: 880 (2) 58810499, 880 (2) 9851211<br/>Fax: 880 (2) 9892585<br/>Cell: 01964499501<br/>Email: info@unigasbd.com<br/>Website: www.unigasbd.com </p>
                    </div>
                </div>
            </div>
        </div>    
        <div class="col-md-8">
            <div class="contact_box">
                <h3><i class="fa fa-pin"></i> Send Your Feedback</h3>
                <div class="contact_form">
                  <div class="row">
                    <div class="col-md-4">
                      <div class="form-group">
                        <label>Your Name:</label>
                        <input type="text" class="form-control" placeholder="Type Your Name" />
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label>Email:</label>
                        <input type="text" class="form-control" placeholder="Type Your Email" />
                      </div>
                    </div>
                      <div class="col-md-4">
                      <div class="form-group">
                        <label>Phone:</label>
                        <input type="text" class="form-control" placeholder="Type Your Phone No" />
                      </div>
                    </div>
                  </div>
                    <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label>Subject/Title:</label>
                        <input type="text" class="form-control" placeholder="Type Your Feedback in details"/>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label>Your Feedback Details:</label>
                        <textarea class="form-control" placeholder="Type Your Feedback Title"></textarea>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group text-center mb-0 ">
                        <input type="submit" class="yellow_btn" value="Send"/>
                      </div>
                    </div>
                  </div>  
                </div>
            </div>
        </div>        
    </div>  
    </div>
</div>
@endsection