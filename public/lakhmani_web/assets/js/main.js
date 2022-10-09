$(document).ready(function () {
            $('#sidebarCollapse').on('click', function () {
                $('#sidebar-form').addClass('active');
                $('.sidebar-overlay').addClass('active');
            });
            $('#dismiss, .sidebar-overlay').on('click', function () {
                $('#sidebar-form').removeClass('active');
                $('.sidebar-overlay').removeClass('active');
            });
        });