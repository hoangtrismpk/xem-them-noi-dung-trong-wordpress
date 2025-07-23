// Chia nội dung bài viết thành 2 phần: hiển thị trước & ẩn sau – không mất ảnh/video
add_filter('the_content', 'devvn_readmore_split_by_paragraph');
function devvn_readmore_split_by_paragraph($content){
    if (is_admin() || !is_singular('post')) return $content;

    // Chia theo đoạn HTML
    $paragraphs = preg_split('/(<\/p>|<\/div>)/i', $content, -1, PREG_SPLIT_DELIM_CAPTURE);
    $combined = [];
    for ($i = 0; $i < count($paragraphs) - 1; $i += 2) {
        $combined[] = $paragraphs[$i] . $paragraphs[$i+1];
    }

    $visible_limit = 3;
    if (count($combined) <= $visible_limit) return $content;

    $visible = implode('', array_slice($combined, 0, $visible_limit));
    $hidden  = implode('', array_slice($combined, $visible_limit));

    ob_start(); ?>
    <div class="td-post-content fix_height">
        <div class="visible-part"><?php echo $visible; ?></div>
        <div class="hidden-part"><?php echo $hidden; ?></div>

        <div class="devvn_readmore_flatsome devvn_readmore_flatsome_more">
            <span class="arrow">
                <span class="chevron"></span>
                <span class="chevron"></span>
                <span class="chevron"></span>
                <span class="text"><a href="javascript:void(0);" aria-expanded="false">Đọc tiếp</a></span>
            </span>
        </div>
        <div class="devvn_readmore_flatsome devvn_readmore_flatsome_less" style="display: none;">
            <a href="javascript:void(0);" aria-expanded="true">Thu gọn</a>
        </div>
    </div>
    <?php
    return ob_get_clean();
}


// CSS + JS điều khiển nút đọc tiếp – chèn luôn footer
add_action('wp_footer', 'devvn_readmore_preserve_html_script', 20);
function devvn_readmore_preserve_html_script() {
?>
<style>
.td-post-content.fix_height .hidden-part {
    max-height: 0;
    overflow: hidden;
    transition: max-height 0.5s ease;
}
.td-post-content.active .hidden-part {
    max-height: 50000px;
}
.arrow {
    position: relative;
    display: flex;
    justify-content: center;
    align-items: center;
}
.chevron {
    position: absolute;
    width: 28px;
    height: 8px;
    opacity: 0;
    transform: scale3d(0.5, 0.5, 0.5);
    animation: move 3s ease-out infinite;
    top: -18%;
}
.chevron:first-child { animation: move 3s ease-out 1s infinite; }
.chevron:nth-child(2) { animation: move 3s ease-out 2s infinite; }
.chevron:before,
.chevron:after {
    content: ' ';
    position: absolute;
    top: 0;
    height: 100%;
    width: 51%;
    background: #000;
}
.chevron:before { left: 0; transform: skew(0deg, 30deg); }
.chevron:after  { right: 0; width: 50%; transform: skew(0deg, -30deg); }
@keyframes move {
    25% { opacity: 1; }
    33% { opacity: 1; transform: translateY(30px); }
    67% { opacity: 1; transform: translateY(40px); }
    100% { opacity: 0; transform: translateY(55px) scale3d(0.5, 0.5, 0.5); }
}
.text {
    display: block;
    margin-top: 55px;
    font-size: 14px;
    color: #000;
    text-transform: uppercase;
    white-space: nowrap;
    opacity: .25;
    animation: pulse 2s linear alternate infinite;
}
@keyframes pulse { to { opacity: 1; } }
.devvn_readmore_flatsome {
    text-align: center;
    cursor: pointer;
    background: #fff;
    margin-top: 10px;
}
.devvn_readmore_flatsome a {
    color: #318A00;
    font-size: 16px;
    font-weight: 700;
    display: block;
}
</style>
<script>
(function($){
    $(document).ready(function(){
        $('body').on('click', '.devvn_readmore_flatsome_more', function(){
            var wrap = $(this).closest('.td-post-content');
            wrap.addClass('active');
            wrap.find('.devvn_readmore_flatsome_more').hide();
            wrap.find('.devvn_readmore_flatsome_less').show();
        });
        $('body').on('click', '.devvn_readmore_flatsome_less', function(){
            var wrap = $(this).closest('.td-post-content');
            wrap.removeClass('active');
            wrap.find('.devvn_readmore_flatsome_less').hide();
            wrap.find('.devvn_readmore_flatsome_more').show();
        });
    });
})(jQuery);
</script>
<?php
}
