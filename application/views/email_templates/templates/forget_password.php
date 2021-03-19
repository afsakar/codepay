<?php
$template = '
<!-- Section-2 -->
<table class="table_full editable-bg-color bg_color_e6e6e6 editable-bg-image" bgcolor="#e6e6e6" width="100%" align="center"  mc:repeatable="castellab" mc:variant="Header" cellspacing="0" cellpadding="0" border="0">
    <tr>
        <td>
            <!-- TITLE -->
            <table class="table1 editable-bg-color bg_color_303f9f" bgcolor="#303f9f" width="600" align="center" border="0" cellspacing="0" cellpadding="0" style="margin: 0 auto;">
                <!-- padding-top -->
                <tr><td height="25"></td></tr>
                <tr>
                    <td>
                        <!-- Inner container -->
                        <table class="table1" width="520" align="center" border="0" cellspacing="0" cellpadding="0" style="margin: 0 auto;">
                            <tr>
                                <td>
                                    <!-- logo -->
                                    <table width="50%" align="left" border="0" cellspacing="0" cellpadding="0">
                                        <tr>
                                            <td align="left">
                                                <a href='.base_url().' class="editable-img">
                                                    <img editable="true" mc:edit="image007" src='.logo("logo").' width="68" style="display:block; line-height:0; font-size:0; border:0;" border="0" alt="logo" />
                                                </a>
                                            </td>
                                        </tr>
                                        <tr><td height="22"></td></tr>
                                    </table><!-- END logo -->
                                </td>
                            </tr>

                            <!-- horizontal gap -->
                            <tr><td height="60"></td></tr>

                            <tr>
                                <td align="center">
                                    <div class="editable-img">
                                        <img editable="true" mc:edit="image009" src='.base_url("uploads/mail/circle-icon-password.png").'  style="display:block; line-height:0; font-size:0; border:0;" border="0" alt="" />
                                    </div>
                                </td>
                            </tr>

                            <!-- horizontal gap -->
                            <tr><td height="40"></td></tr>

                            <tr>
                                <td mc:edit="text009" align="center" class="text_color_ffffff" style="color: #ffffff; font-size: 30px; font-weight: 700; font-family: lato, Helvetica, sans-serif; mso-line-height-rule: exactly;">
                                    <div class="editable-text">
										<span class="text_container">
											<multiline>
												{TITLE}
											</multiline>
										</span>
                                    </div>
                                </td>
                            </tr>

                            <!-- horizontal gap -->
                            <tr><td height="30"></td></tr>
                        </table><!-- END inner container -->
                    </td>
                </tr>
                <!-- padding-bottom -->
                <tr><td height="104"></td></tr>
            </table><!-- END container -->
        </td>
    </tr>

    <tr>
        <td>
            <!-- CONTENT -->
            <table class="table1 editable-bg-color bg_color_ffffff" bgcolor="#ffffff" width="600" align="center" border="0" cellspacing="0" cellpadding="0" style="margin: 0 auto;">
                <!-- padding-top -->
                <tr><td height="60"></td></tr>

                <tr>
                    <td>
                        <!-- inner container -->
                        <table class="table1" width="520" align="center" border="0" cellspacing="0" cellpadding="0" style="margin: 0 auto;">

                            <tr>
                                <td mc:edit="text018" align="left" class="center_content text_color_a1a2a5" style="color: #a1a2a5; font-size: 14px;line-height: 2; font-weight: 500; font-family: lato, Helvetica, sans-serif; mso-line-height-rule: exactly;">
                                    <div class="editable-text" style="line-height: 2;">
										<span class="text_container">
											<multiline>
                                                {CONTENT}
                                            </multiline>
										</span>
                                    </div>
                                </td>
                            </tr>
                        </table><!-- END inner container -->
                    </td>
                </tr>

                <!-- padding-bottom -->
                <tr><td height="60"></td></tr>
            </table><!-- END container -->
        </td>
    </tr>
</table>
<!-- END wrapper -->
';