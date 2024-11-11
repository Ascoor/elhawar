
        
        {{-- @if($global->dashboard_clock)
            <span id="clock" class="dashboard-clock text-muted m-r-30"></span>
        @endif --}}

        
        <select id="selectLang" class="selectpicker language-switcher  pull-right" data-width="fit">

            @if($global->timezone == "Europe/London")
               <option value="en" @if($global->locale == "en") selected @endif data-content='<span class="flag-icon flag-icon-gb"></span>'>En</option>
               @else
               <option value="en" @if($global->locale == "en") selected @endif data-content='<span class="flag-icon flag-icon-us"></span>'>En</option>
               @endif
            @foreach($languageSettings as $language)
                <option value="{{ $language->language_code }}"
                        @if($global->locale == $language->language_code) selected
                        @endif  data-content='<span class="flag-icon
                        @if($language->language_code == 'zh-CN') flag-icon-cn
                        {{-- @elseif($language->language_code == 'zh-TW') flag-icon-tw --}}
                        @else flag-icon-{{ $language->language_code == 'ar' ? 'eg' :  $language->language_code }}
                        @endif"></span>'>{{ $language->language_code }}
                </option>
            @endforeach
        </select>


    
    
    {{-- </div>  --}}

     {{--end language date-------------- --}}
{{-- </div> --}}
{{-- @endsection --}}

<script src="{{ asset('plugins/bower_components/raphael/raphael-min.js') }}"></script>
<script src="{{ asset('plugins/bower_components/morrisjs/morris.js') }}"></script>

<script src="{{ asset('plugins/bower_components/waypoints/lib/jquery.waypoints.js') }}"></script>
<script src="{{ asset('plugins/bower_components/counterup/jquery.counterup.min.js') }}"></script>

<!-- jQuery for carousel -->
<script src="{{ asset('plugins/bower_components/owl.carousel/owl.carousel.min.js') }}"></script>
<script src="{{ asset('plugins/bower_components/owl.carousel/owl.custom.js') }}"></script>

<!--weather icon -->
<script src="{{ asset('plugins/bower_components/skycons/skycons.js') }}"></script>

<script src="{{ asset('plugins/bower_components/moment/moment.js') }}"></script>
<script src="{{ asset('plugins/bower_components/calendar/dist/fullcalendar.min.js') }}"></script>
<script src="{{ asset('plugins/bower_components/calendar/dist/jquery.fullcalendar.js') }}"></script>
<script src="{{ asset('plugins/bower_components/calendar/dist/locale-all.js') }}"></script>
<script src="{{ asset('js/event-calendar.js') }}"></script>
<script src="{{ asset('plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('js/moment-timezone.js') }}"></script>

<script>
    
   
    var calendarLocale = '{{ $global->locale }}';
    var firstDay = '{{ $global->week_start }}';
   

    $('.keep-open .dropdown-menu').on({
        "click":function(e){
            e.stopPropagation();
        }
    });
    $('[data-toggle="tooltip"]').tooltip();
    $('#save-form').click(function () {
        $.easyAjax({
            url: '{{route('admin.dashboard.widget', "admin-dashboard")}}',
            container: '#createProject',
            type: "POST",
            redirect: true,
            data: $('#createProject').serialize(),
            success: function(){
                window.location.reload();
            }
        })
    });

  
    /** clock timer start here */
    function currentTime() {
        let date = new Date();
        date = moment.tz(date, "{{ $global->timezone }}");

        // console.log(moment.tz(date, "America/New_York"));

        let hour = date.hour();
        let min = date.minutes();
        let sec = date.seconds();
        let midday = "AM";
        midday = (hour >= 12) ? "PM" : "AM";
        @if($global->time_format == 'h:i A')
            hour = (hour == 0) ? 12 : ((hour > 12) ? (hour - 12): hour); /* assigning hour in 12-hour format */
        @endif
            hour = updateTime(hour);
        min = updateTime(min);
        document.getElementById("clock").innerText = `${hour} : ${min} ${midday}`
        const time = setTimeout(function(){ currentTime() }, 1000);
    }

    function updateTime(timer) {
        if (timer < 10) {
            return "0" + timer;
        }
        else {
            return timer;
        }
    }
    currentTime();
    $('.selectpicker').change(function () {
        var rtl  = document.getElementById("selectLang").value==='ar';
        $.easyAjax({
            url: '{{route('admin.theme-settings.rtlThemeLang')}}',
            type: "POST",
            data: {'_token': '{{ csrf_token() }}', 'rtl': rtl}
        })
        return false;
    });
</script>