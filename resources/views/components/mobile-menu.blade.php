<div id="MobileMenuContainer">
    <div id="MobileMenuHeader">
        <div id="HamburgerIcon" onclick="openNav()">
            <img src="{{asset('images/mobileMenu.png')}}" alt="menu-icon">
        </div>
        <div id="KhoshNazarText">
            سامانه رشد خوش نظر
        </div>
        {{-- <div id="GoBack" onclick="document.location.href='{{route('dashboard')}}'">
            بازگشت &gt;
        </div> --}}
    </div>
    <div id="mySidebar" class="MobilSidebar">
        <div id="mobileSidebarHeader">
            <div class="SidebarKhoshNazarText">
                سامانه رشد خوش نظر
            </div>
            <div id="SidbarGoBack" onclick="closeNav()">
               <i class="fa fa-close"></i>
            </div>
           
        </div>
        <div>
            <figure id="menuavatar">
                        <img src="{{asset("images/avatar.png")}}">
                        <figcaption>{{auth()->user()->phone}}</figcaption>
                    </figure>
        </div>
        <div id="MobileDashboardExamExitButton" style="margin-top:1rem;">           
                    
                <ul style="list-style-type: none;width: 100%;padding: 7%;font-size: 20pt;">
                    <li>
                        <a href="/" style="font-size: 10pt; "> 
                            <i class="fa fa-home"></i>                        
                          <span style="padding-right: 2%"> خانه</span>
                        </a>
                    </li>
                    @if(is_null(session('chk')))
                    <li>
                        <a href="/identify/exams" style="font-size: 10pt; ">
                            <i class="fa fa-diamond"></i>                        
                          <span style="padding-right: 2%"> استعدادیابی کودک</span>                        
                            
                        </a>
                    </li>
                    <li>
                        <a href="/suggest/exams" style="font-size: 10pt; ">
                            <i class="fa fa-diamond"></i>                        
                          <span style="padding-right: 2%"> آزمون های پیشنهادی</span>
                            
                        </a>
                    </li>
                    @endif
                    @php
                        $ex=\App\Models\Exam::find(6);
                    @endphp
                    @if($ex)
                    <li>
                        <a href="{{route('myinfo',$ex->id)}}" style="font-size: 10pt; ">
                            <i class="fa fa-diamond"></i>                        
                          <span style="padding-right: 2%"> {{$ex->name}}</span>
                            
                        </a>
                    </li>                    
                    @endif
                    <li onclick="location.href='{{route('logout')}}';" style="border: 2px solid;border-radius: 5px; text-align: center; margin-top:55%;background: white;">
                        <a href="{{route('logout')}}" style="font-size: 13pt;color:#fb4d64 ">
                            <i class="fa fa-sign-out"></i>                        
                          <b style="padding-right: 2%"> خروج</b>
                            
                        </a>
                    </li>
                   
                </ul>
        </div>
        {{-- <div id="MobileDashboardExamExitButton" style="margin-top: 25rem;">
            <img src="{{asset('images/exitIcon.png')}}" alt="exit">
            <a href="{{route('logout')}}">خروج</a>
        </div> --}}
    </div>
</div>