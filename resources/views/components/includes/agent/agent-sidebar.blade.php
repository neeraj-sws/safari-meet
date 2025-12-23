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
                                  <a href="{{ route('agent.dashboard') }}">
                                      <div class="parent-icon"><i class="bx bx-home-circle"></i>
                                      </div>
                                      <div class="menu-title">Dashboard</div>
                                  </a>
                              </li>
                              <li>
                                  <a href="{{ route('agent.package.package') }}">
                                      <div class="parent-icon">
                                        <i class="bx bx-package"></i>
                                      </div>
                                      <div class="menu-title">Packages</div>
                                  </a>
                              </li>
                              <li>
                                  <a href="{{ route('agent.enquiries') }}">
                                      <div class="parent-icon">
                                        <i class="bx bx-package"></i>
                                      </div>
                                      <div class="menu-title">Enquiries</div>
                                  </a>
                              </li>
                              <li>
                                  <a href="{{ route('agent.shared-safari.safari') }}">
                                      <div class="parent-icon">
                                        <i class="bx bx-package"></i>
                                      </div>
                                      <div class="menu-title">Shared Safari</div>
                                  </a>
                              </li>
                              <li>
                                  <a href="{{ route('agent.agentaccommodation') }}">
                                      <div class="parent-icon">
                                        <i class="bx bx-package"></i>
                                      </div>
                                      <div class="menu-title">Accommodations</div>
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
