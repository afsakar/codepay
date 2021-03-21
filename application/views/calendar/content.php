<div class="content">
    <!-- Calendar and Events functionality is initialized in js/pages/be_comp_calendar.min.js which was auto compiled from _es6/pages/be_comp_calendar.js -->
    <!-- For more info and examples you can check out https://fullcalendar.io/ -->
    <div class="block">
        <div class="block-content">
            <div class="row items-push">
                <div class="col-xl-3">
                    <div class="block-header">
                        <h5 class="block-title"><?= trans("add_event") ?></h5>
                    </div>
                    <!-- Add Event Form -->
                    <form action="<?= base_url("dashboard/addItem") ?>" method="post">
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="<?= trans("add_event") ?>" name="title"
                                   required>
                        </div>
                        <div class="form-group">
                            <input type="text" class="js-flatpickr form-control bg-white" id="start_date"
                                   name="start_date" placeholder="<?= trans("start_date") ?>" required
                                   data-week-start="1" data-autoclose="true" data-today-highlight="true"
                                   data-date-format="Y/m/d">
                        </div>
                        <div class="form-group">
                            <input type="text" class="js-flatpickr form-control bg-white" id="end_date" name="end_date"
                                   placeholder="<?= trans("end_date") ?>" required data-week-start="1"
                                   data-autoclose="true" data-today-highlight="true" data-date-format="Y/m/d">
                        </div>
                        <div class="form-group">
                            <div class="js-colorpicker input-group" data-format="hex">
                                <input type="text" class="form-control" id="example-colorpicker2" name="bgColor"
                                       placeholder="<?= trans("background_color") ?>" required>
                                <div class="input-group-append">
                                    <span class="input-group-text colorpicker-input-addon">
                                        <i></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="js-colorpicker input-group" data-format="hex">
                                <input type="text" class="form-control" id="example-colorpicker2" name="textColor"
                                       placeholder="<?= trans("text_color") ?>" required>
                                <div class="input-group-append">
                                    <span class="input-group-text colorpicker-input-addon">
                                        <i></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-alt-primary btn-block"><i
                                        class="fa fa-save"></i> <?= trans("save") ?></button>
                        </div>
                    </form>
                    <!-- END Add Event Form -->
                </div>
                <div class="col-xl-9 calendarContainer">
                    <!-- Calendar Container -->
                    <div id='calendar'></div>
                </div>
            </div>
        </div>
    </div>