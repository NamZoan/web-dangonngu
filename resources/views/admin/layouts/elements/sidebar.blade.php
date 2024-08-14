<div class="col-md-3 left_col menu_fixed">
    <div class="left_col scroll-view">
        <div class="navbar nav_title" style="border: 0;">
            <a href="{{ route('web_home', 'vi') }}" target="_blank" rel="noopener noreferrer" class="site_title"><i
                    class="fa fa-home"></i> <span>Trang chủ</span></a>
        </div>

        <div class="clearfix"></div>

        <br />

        <!-- sidebar menu -->
        <div id="sidebar-menu" class="main_menu_side hidden-print main_menu ">
            <div class="menu_section">
                <h3>Entities</h3>
                <ul class="nav side-menu">
                    <li><a><i class="fa fa-suitcase"></i> Sản phẩm <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><a href="{{ route('admin_product_category_index') }}">Danh mục</a></li>
                            <li><a href="{{ route('admin_product_index') }}">Sản phẩm</a></li>
                        </ul>
                    </li>
                    <li><a><i class="fa fa-file-word-o"></i> Bài viết <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><a href="{{ route('admin_post_category_index') }}">Danh mục</a></li>
                            <li><a href="{{ route('admin_post_index') }}">Bài viết</a></li>
                        </ul>
                    </li>
                    <li><a href="{{ route('admin_order_index') }}"><i class="fa fa-cart-arrow-down"></i>Đơn Hàng</a>
                    <li><a href="{{ route('admin_information_index') }}"><i class="fa fa-info"></i>Thông tin</a>
                </ul>
            </div>
            <div class="menu_section">
                <h3>Config</h3>
                <ul class="nav side-menu">
                    <li><a><i class="fa fa-cog"></i> Cấu hình <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><a href="{{ route('admin_config_home') }}">Trang chủ</a></li>
                            <li><a href="{{ route('admin_config_payment') }}">Thanh toán</a></li>
                            <li><a href="{{ route('admin_config_headerAndFooter') }}">Header và Footer</a></li>
                            <li><a href="glyphicons.html">Glyphicons</a></li>
                            <li><a href="widgets.html">Widgets</a></li>
                            <li><a href="invoice.html">Invoice</a></li>
                            <li><a href="inbox.html">Inbox</a></li>
                            <li><a href="calendar.html">Calendar</a></li>
                        </ul>
                    </li>
                    <li><a><i class="fa fa-bar-chart-o"></i> Thống kê <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><a href="chartjs.html">Chart JS</a></li>
                            <li><a href="chartjs2.html">Chart JS2</a></li>
                            <li><a href="morisjs.html">Moris JS</a></li>
                            <li><a href="echarts.html">ECharts</a></li>
                            <li><a href="other_charts.html">Other Charts</a></li>
                        </ul>
                    </li>
                    <li><a href="{{ route('admin_manage_files') }}"><i class="fa fa-folder"></i> File Manager</a>
                    </li>
                    <li><a><i class="fa fa-language"></i> Ngôn ngữ <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><a href="{{ route('admin_language') }}">Quốc Gia</a></li>
                            <li><a href="{{ route('admin_language_line') }}">Dòng Text</a></li>
                        </ul>
                    </li>
                </ul>
            </div>

        </div>
        <!-- sidebar menu -->
    </div>
</div>
