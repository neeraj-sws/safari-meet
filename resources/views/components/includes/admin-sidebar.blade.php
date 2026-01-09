  <div class="sidebar-wrapper" data-simplebar="init">
      <div class="simplebar-wrapper" style="margin: 0px;">
          <div class="simplebar-height-auto-observer-wrapper">
              <div class="simplebar-height-auto-observer"></div>
          </div>
          <div class="simplebar-mask">
              <div class="simplebar-offset" style="right: 0px; bottom: 0px;">
                  <div class="simplebar-content-wrapper" style="height: 100%; overflow: hidden scroll;">
                      <div class="simplebar-content mm-active" style="padding: 0px;">
                          <div class="sidebar-header">
                              <div>
                                  <img src="{{ asset(\App\Helpers\SettingHelper::get('site_logo', 'assets/images/WLogoLightgreen.svg')) }}"
                                      class="logo-icon" alt="logo icon">
                              </div>
                              <div>
                                  <h4 class="logo-text">
                                      {{ \App\Helpers\SettingHelper::get('site_name', config('app.name')) }}</h4>
                              </div>
                              <div class="toggle-icon ms-auto"><i class="bx bx-arrow-to-left"></i>
                              </div>
                          </div>
                          <!--navigation-->
                          <ul class="metismenu mm-show" id="menu">
                              <li>
                                  <a href="{{ route('admin.dashboard') }}">
                                      <div class="parent-icon"><i class="bx bx-home-circle"></i>
                                      </div>
                                      <div class="menu-title">Dashboard</div>
                                  </a>
                              </li>

                              <li class="">
                                  <a class="has-arrow" href="javascript:;">
                                      <div class="parent-icon"><i class="lni lni-users"></i>
                                      </div>
                                      <div class="menu-title">All Users</div>
                                  </a>
                                  <ul class="mm-collapse">
                                      <li> <a href="{{ route('admin.travel_agent') }}"><i
                                                  class="lni lni-users"></i>Travel Agents</a>
                                      </li>
                                      <li> <a href="{{ route('admin.allUser') }}"><i class="lni lni-users"></i>Users</a>
                                      </li>
                                  </ul>
                              </li>


                              <li class="">
                                  <a class="has-arrow" href="javascript:;">
                                      <div class="parent-icon"><i class="bx bx-message-square-dots"></i>
                                      </div>
                                      <div class="menu-title">All Enquiries</div>
                                  </a>
                                  <ul class="mm-collapse">
                                      <li> <a href="{{ route('admin.packageenquiries') }}"><i
                                                  class="bx bx-message-square-dots"></i>Package Enquiries</a>
                                      </li>
                                      <li> <a href="{{ route('admin.enquiries') }}"><i
                                                  class="bx bx-message-square-dots"></i>Enquiries</a>
                                      </li>
                                      <li> <a href="{{ route('admin.contact-submissions') }}"> <i
                                                  class="bx bx-message-square-dots"></i>Contact Us Enquiries</a>
                                      </li>
                                  </ul>
                              </li>

                              <li>
                                  <a class="has-arrow" href="javascript:;">
                                      <div class="parent-icon"><i class="bx bx-grid-alt"></i>
                                      </div>
                                      <div class="menu-title">Modules</div>
                                  </a>
                                  <ul class="mm-collapse">
                                      <li> <a class="has-arrow" href="javascript:;"><i
                                                  class="bx bx-share-alt"></i>Species</a>
                                          <ul class="mm-collapse">
                                              <li> <a href="{{ route('admin.species.speciesCharacterstics') }}"><i
                                                          class="bx bx-dna"></i>Species Characterstics</a></li>
                                              <li> <a href="{{ route('admin.species.species') }}"><i
                                                          class="bx bx-dna"></i>Species</a></li>
                                          </ul>
                                      </li>

                                      <li> <a class="has-arrow" href="javascript:;"><i class="bx bx-map"></i>National
                                              Praks</a>
                                          <ul class="mm-collapse">
                                              <li> <a href="{{ route('admin.park.speciesCharacterstics') }}"><i
                                                          class="bx bx-list-check"></i>Park Information Tabs</a></li>
                                              {{-- <li> <a href="{{ route('admin.park.park_rule') }}"><i class="bx bx-list-check"></i>Park Rules</a></li> --}}
                                              <li> <a href="{{ route('admin.park.park') }}"><i
                                                          class="bx bx-list-ul"></i>Park List</a></li>
                                          </ul>
                                      </li>

                                      <li> <a class="has-arrow" href="javascript:;"><i
                                                  class="bx bx-share-alt"></i>Safari Packages</a>
                                          <ul class="mm-collapse">
                                              <li> <a href="{{ route('admin.package.characterstics') }}"><i
                                                          class="bx bx-share-alt"></i>Information Tabs</a></li>
                                              <li> <a href="{{ route('admin.package.package') }}"><i
                                                          class="bx bx-package"></i>Packages</a></li>
                                          </ul>
                                      </li>

                                      <li> <a class="has-arrow" href="javascript:;"><i
                                                  class="bx bx-share-alt"></i>Shared Safari</a>
                                          <ul class="mm-collapse">
                                              <li> <a href="{{ route('admin.sharedsafari.safariCharacterstics') }}"><i
                                                          class="bx bx-share-alt"></i>Inormation</a></li>
                                              <li> <a href="{{ route('admin.sharedsafari.share.safari') }}"><i
                                                          class="bx bx-share-alt"></i>Shared Safari</a></li>
                                          </ul>
                                      </li>

                                  </ul>
                              </li>
                              <li>
                                  <a href="{{ route('admin.transaction-history') }}">
                                      <div class="parent-icon">
                                          <i class="bx bx-message-square-dots"></i>
                                      </div>
                                      <div class="menu-title">Transaction History</div>
                                  </a>
                              </li>

                              <li class="">
                                  <a class="has-arrow" href="javascript:;">
                                      <div class="parent-icon"><i class="bx bx-cog"></i>
                                      </div>
                                      <div class="menu-title">Master Settings</div>
                                  </a>
                                  <ul class="mm-collapse">
                                      <li> <a href="{{ route('admin.countries') }}"><i
                                                  class="bx bx-globe"></i>Countries</a></li>
                                      <li> <a href="{{ route('admin.states') }}"><i
                                                  class="bx bx-map-pin"></i>States</a></li>
                                      <li> <a href="{{ route('admin.city') }}"><i class="bx bx-map-pin"></i>City</a>
                                      </li>
                                      <li> <a href="{{ route('admin.coupon') }}"><i
                                                  class="bx bx-map-pin"></i>Coupons</a>
                                      </li>
                                  </ul>
                              </li>





                              <li class="">
                                  <a class="has-arrow" href="javascript:;">
                                      <div class="parent-icon"><i class="bx bx-layer"></i>
                                      </div>
                                      <div class="menu-title">Safari Masters</div>
                                  </a>
                                  <ul class="mm-collapse">
                                      <li> <a href="{{ route('admin.accommodationList') }}"><i
                                                  class="bx bx-photo-album"></i>Accommodations</a></li>
                                      {{-- <li> <a href="{{ route('admin.quotes') }}">
                                          <i class="lni lni-checkmark-circle"></i>
                                          Quotes Accommodations</a> </li> --}}
                                      <li> <a href="{{ route('admin.amenities') }}"><i
                                                  class="bx bx-plus-medical"></i>Amenities</a> </li>
                                      <li> <a href="{{ route('admin.features') }}"><i
                                                  class="bx bx-star"></i>Inclusion-Exclusion</a>
                                      </li>
                                      <li> <a href="{{ route('admin.reachability_modes') }}"><i
                                                  class="bx bx-navigation"></i>Reachability Modes</a> </li>
                                      <li> <a href="{{ route('admin.reportresion') }}"><i
                                                  class="bx bx-navigation"></i>Report Resion</a> </li>
                                      <li> <a href="{{ route('admin.report') }}"><i
                                                  class="bx bx-navigation"></i>Reports</a> </li>
                                      <li> <a href="{{ route('admin.safari_type') }}"><i
                                                  class="bx bx-category"></i>Safari
                                              Types</a></li>
                                      <li> <a href="{{ route('admin.species.categories') }}"><i
                                                  class="bx bx-category-alt"></i> Species Categories</a></li>
                                      <li> <a href="{{ route('admin.species_family') }}"><i
                                                  class="bx bx-category-alt"></i>Species Family</a></li>
                                      <li> <a href="{{ route('admin.species_genus') }}"><i
                                                  class="bx bx-category-alt"></i>Species Genus</a></li>
                                      {{-- <li> <a href="{{ route('admin.system_faq') }}"><i
                                              class="bx bx-navigation"></i>System
                                          Faq</a> </li> --}}
                                      <li> <a href="{{ route('admin.things_to_carries') }}"><i
                                                  class="bx bx-briefcase"></i>Thing To Carries</a> </li>
                                      <li> <a href="{{ route('admin.weather') }}"><i
                                                  class="lni lni-thunder-alt"></i>Weather</a></li>
                                      <li> <a href="{{ route('admin.failed-jobs') }}"><i
                                                  class="lni lni-thunder-alt"></i>Failed Jobs</a></li>
                                      <li> <a href="{{ route('admin.activity-log') }}"><i
                                                  class="lni lni-thunder-alt"></i>Activity Log</a></li>
                                      <li class="">
                                          <a class="has-arrow" href="javascript:;">
                                              <div class="parent-icon"><i class="bx bx-cog"></i>
                                              </div>
                                              <div class="menu-title">Notification</div>
                                          </a>
                                          <ul class="mm-collapse">
                                              <li> <a href="{{ route('admin.notification.template') }}">
                                                      <i class="bx bx-globe"></i>Templates</a>
                                              </li>

                                          </ul>
                                      </li>
                                  </ul>
                              </li>
                              <li>
                                  <a href="{{ route('admin.social.mediapost') }}">
                                      <div class="parent-icon">
                                          <i class="bx bx-message-square-dots"></i>
                                      </div>
                                      <div class="menu-title">Media Post</div>
                                  </a>
                              </li>


                              <li class="">
                                  <a class="has-arrow" href="javascript:;">
                                      <div class="parent-icon"><i class="bx bx-file"></i>
                                      </div>
                                      <div class="menu-title">Static Pages</div>
                                  </a>
                                  <ul class="mm-collapse">
                                      <!--<li> <a href="{{ route('admin.albums') }}"><i-->
                                      <!--            class="bx bx-photo-album"></i>Albums</a></li>-->
                                      <!--<li> <a href="{{ route('admin.contact_us') }}"><i-->
                                      <!--            class="bx bx-envelope"></i>Contact Us</a></li>-->
                                      <li> <a href="{{ route('admin.cleardata.cleardata') }}"><i
                                                  class="lni lni-trash"></i>Data Cleaner</a></li>
                                      <li> <a href="{{ route('admin.why_verify_profile') }}"><i
                                                  class="bx bx-info-circle"></i>Why Verify Profile</a></li>
                                      <li> <a href="{{ route('admin.about_us') }}"><i
                                                  class="bx bx-info-circle"></i>About
                                              Us</a></li>
                                      <li> <a href="{{ route('admin.privacy_policy') }}"><i
                                                  class="bx bx-lock-alt"></i>Privacy Policy</a></li>
                                      <li> <a href="{{ route('admin.refund_policy') }}"><i
                                                  class="bx bx-undo"></i>Refund
                                              Policy</a></li>
                                      <li> <a href="{{ route('admin.terms_and_conditions') }}"><i
                                                  class="	bx bx-file"></i>Terms and Conditions</a></li>
                                      <li> <a class="has-arrow" href="javascript:;"><i
                                                  class="bx bx-question-mark"></i>Faq</a>
                                          <ul class="mm-collapse">
                                              <li> <a href="{{ route('admin.faqs.category') }}"><i
                                                          class="bx bx-category-alt"></i>Faqs Category</a> </li>
                                              <li> <a href="{{ route('admin.faqs') }}"><i
                                                          class="bx bx-help-circle"></i>Faq</a> </li>
                                          </ul>
                                      </li>
                                  </ul>
                              </li>

                              <li>
                                  <a href="{{ route('admin.seo_pages') }}">
                                      <div class="parent-icon"><i class="fa fa-search-location"></i>
                                      </div>
                                      <div class="menu-title">SEO Pages</div>
                                  </a>
                              </li>
                              <li>
                                  <a href="{{ route('admin.settings') }}">
                                      <div class="parent-icon"><i class="bx bx-slider"></i>
                                      </div>
                                      <div class="menu-title">Site Settings</div>
                                  </a>
                              </li>
                              <li>
                                  <a href="{{ route('admin.home_page_banner') }}">
                                      <div class="parent-icon"><i class="bx bx-home-circle"></i>
                                      </div>
                                      <div class="menu-title">Home Page Banner</div>
                                  </a>
                              </li>

                          </ul>
                          <!--end navigation-->
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </div>
