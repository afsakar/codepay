<footer id="page-footer" class="opacity-0">
    <div class="content py-20 font-size-sm clearfix">
        <div class="float-right">
            <?=copyright()?>
        </div>
        <div class="float-left">
            Copryrigt © <?=settings("footer_text") != "" ? settings("footer_text") : settings("title")?> | <?=trans("all_rights")?> <span class="js-year-copy"></span>
        </div>
    </div>
</footer>