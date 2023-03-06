@extends('layouts.app')

@section('content')
    @include('includes.messages')

<!-- <style>
    input[type="number"] {
    appearance: textfield;
    -webkit-appearance: textfield;
    -moz-appearance: textfield;
    }
</style> -->

    <div class="user__dashboard container-py">
        <div class="row">
            <div class="col">
                    <div id="task-overlay">

                        <form action="{{ route('user.logout', ['id' => Auth::user()->id]) }}" class="text-dark text-left" autocomplete="off" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="task__overlay">
                                <div class="task__overlay__item">
                                    <div class="card" onclick="task_on()">
                                        <div class="card-header">
                                            <div class="task__overlay__item">
                                                <div class="task__overlay__header">{{ __('Task Report') }}</div>
                                                <button  onclick="window.location.reload();" class="task__overlay__button">x</button>
                                            </div>
                                        </div>

                                        <div class="card-body">
                                            <div class="card-group">
                                                <label for="position" class="col-6">Position<span class="text-red">*</label>
                                                <input data-role="tagsinput" type="text" class="col" id="position" name="position" value="{{ Auth::user()->position }}" disabled>

                                            </div>

                                            <!-- <div class="card-body">
                                                <div class="card-group"> -->
                                                    <!-- <div class="customer_records">
                                                        <a class="extra-fields-customer" href="#">+</a>
                                                        <input name="customer_name" type="text" placeholder="Project">
                                                    </div>

                                                    <div class="customer_records_dynamic"></div> -->
                                                <!-- </div>
                                            </div> -->

                                            <div class="card-group">
                                                <label for="location" class="col-6">Location <span class="text-red">*</label>
                                                <select name="location" id="location" class="col" required>
                                                    <option value="" class="hidden">Choose</option>
                                                    <option value="Work from Home (WFH)">Work from Home (WFH)</option>
                                                    <option value="On-site">On-site</option>
                                                </select>
                                            </div>

                                            <div class="card-group">
                                                <label for="project" class="col-6">Project<span class="text-red">*</label>
                                            </div>

                                            <div class="card-group">
                                                <textarea type="text" class="col" id="project" name="project" placeholder="Project 1, Project 2,..." value="{{ Auth::user()->project }}"  required></textarea>
                                            </div>

                                            <div class="card-group">
                                                <label for="task" class="col-6">Tasks Done for the Day<span class="text-red">*</label>
                                            </div>

                                            <div class="card-group">
                                                <textarea class="col" name="task" placeholder="Enter all completed task done today" required></textarea>
                                            </div>
                                        </div>


                                        <div class="task__overlay__cta">
                                            <button type="submit">{{ __('Submit') }}</button>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                <div class="user__dashboard__grid">
                    <div class="user__dashboard__item">
                        <div class="user__dashboard__description">
                            
                            <div class="user__dashboard__title">Hello, <span>{{ Auth::user()->username }}!</span></div>
                            <div class="user__dashboard__info">You have successfully marked your attendance!</div>
                            <div class="user__dashboard__timer">
    
                                <div class="card">
                                    <div class="card-header">
                                    @if(!Auth::user()->time_out)
                                    <div class="time-track">Time consumed:</div>
                                    <div id="counter" class="text-center text-black"></div>
                                    @elseif(Auth::user()->time_out)
                                    <div class="time-track-done">You have already timed out for this day!</div>

                                    @endif
    
                                    
                                        <!-- <div class="card-header" id="clocks">Loading...</div> -->
                                    </div>
                                    <div class="card-body">
                                        <div class="user__dashboard__content">
                                            <div class="user__dashboard__title m-b-md">
                                                <div class="user__dashboard__clockStyle" id="clock">Loading...</div>
                                            </div>
                                        </div>
                                        @if (session('status'))
                                            <div class="alert alert-success" role="alert">
                                                {{ session('status') }}
                                            </div>
                                        @endif
                                        <div class="user__dashboard__cta">
                                            <!-- <button type="submit" class="btn btn-primary col">{{ __('Time in') }}</button> -->
                                            @if(Auth::user()->time_out)
                                            <button disabled="disabled" style="visibility:hidden" onclick="task_on()">Time Out</button>
                                            @elseif(Auth::user()->time_in)
                                            <button onclick="task_on()">Time Out</button>
                                            @endif
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="user__dashboard__calendar">
                            <div class="card">
                                <div class="calendar">
                                    <div class="calendar-header">
                                        <span>Activity</span>
                                        <div class="month-picker">
                                            <span class="month-change" id="prev-month">
                                                <pre><</pre>
                                            </span>
                                            <span class="month-picker" id="month-picker">Month</span>
                                            <span class="year" id="year">Year</span>
                                            <span class="month-change" id="next-month">
                                                <pre>></pre>
                                            </span>
                                        </div>
                                    </div>
                                    <hr class="mx-2 my-0">
                                    <div class="calendar-body">
                                        <div class="calendar-week-day">
                                            <div>S</div>
                                            <div>M</div>
                                            <div>T</div>
                                            <div>W</div>
                                            <div>TH</div>
                                            <div>F</div>
                                            <div>S</div>
                                        </div>
                                        <div class="calendar-days"></div>
                                    </div>
                                    <div class="month-list"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
@endsection

@section('script')
    <script>
        setInterval(displayclock, 500);

        function displayclock() {
            var time = new Date();
            var hrs = time.getHours();
            var min = time.getMinutes();
            var sec = time.getSeconds();
            var en = 'AM';
            if (hrs > 12) {
                en = 'PM';
            }
            if (hrs > 12) {
                hrs = hrs - 12;
            }
            if (hrs == 0) {
                hrs = 12;
            }
            if (hrs < 10) {
                hrs = '0' + hrs;
            }
            if (min < 10) {
                min = '0' + min;
            }
            if (sec < 10) {
                sec = '0' + sec;
            }
            document.getElementById("clock").innerHTML = hrs + ':' + min + ':' + sec + ' ' + en;
        }

        const element = document.getElementById('date');
        element.valueAsNumber = Date.now() - (new Date()).getTimezoneOffset() * 60000;
    </script>
    

    <script>
        <?php 

           //Formula for running log time
           $dateTime = strtotime(Auth::user()->time_in);
           $getDateTime = date("F d, Y H:i:s", $dateTime); 
        ?>
        var countDownDate = new Date("<?php echo "$getDateTime"; ?>").getTime();
        // Update the count down every 1 second
        var x = setInterval(function() {
            var now = new Date().getTime();
            // Find the distance between now an the count down date
            var distance = now - countDownDate;
            // Time calculations for days, hours, minutes and seconds
            var days = Math.floor(distance / (1000 * 60 * 60 * 24));
            var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            var seconds = Math.floor((distance % (1000 * 60)) / 1000);
            // Output the result in an element with id="counter"11
         
            // if(Auth::user()->time_in == null){
                document.getElementById("counter").innerHTML = + hours + "h " +
            minutes + "m " + seconds + "s ";
          
           
            // If the count down is over, write some text 
            if (distance < 0) {
                clearInterval(x);
                document.getElementById("counter").innerHTML = "EXPIRED";
            }
        }, 1000);
    </script>
    
@endsection
