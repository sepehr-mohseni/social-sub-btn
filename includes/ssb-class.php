<?php

/**
 * Adds Social_Sub_Btns_Widget widget.
 */
class Social_Sub_Btns_Widget extends WP_Widget
{

    /**
     * Register widget with WordPress.
     */
    function __construct()
    {
        parent::__construct(
            'ssb_widget', // Base ID
            esc_html__('Social Sub Buttons', 'ssb_domain'), // Name
            array('description' => esc_html__('Widget to display Social Sub Buttons', 'ssb_domain'),) // Args
        );
    }

    /**
     * Front-end display of widget.
     *
     * @see WP_Widget::widget()
     *
     * @param array $args     Widget arguments.
     * @param array $instance Saved values from database.
     */
    public function widget($args, $instance)
    {
        echo $args['before_widget']; // Whatever you want to display before widget (<div>, etc)

        if (!empty($instance['title'])) {
            echo $args['before_title'] . apply_filters('widget_title', $instance['title']) . $args['after_title'];
        }

        $title = $instance['title'];
        $url = $instance['url'];
        $theme = $instance['theme'];
        if ($instance['type'] == 'gh') {
            $urlToFollow = "https://github.com/{$url}";
            $layout = $theme == 'full' ? "
            data-color-scheme='no-preference: dark; light: dark; dark: dark;'
            data-size='large'
            data-show-count='true'"
                : "";
            echo "
            <div 
            style='direction: ltr !important;'>
            <a 
            class='github-button'
            href={$urlToFollow}
            {$layout}
            aria-label={$title}>
            {$title}
            </a>
            </div>
            ";
        } else if ($instance['type'] == 'yt') {
            $channel = $url;
            $layout = $theme == 'full' ?
                "data-layout='full' data-count='default'"
                :
                "data-layout='default' data-count='hidden'";
            echo "
            <div 
            class='g-ytsubscribe'
            data-channel='{$channel}'
            {$layout}
             </div>
             ";
        } else if ($instance['type'] == 'sp') {
            $tornURL = explode('/', $url);
            $frameTheme = $theme == 'default' ? '&theme=0' : '';
            $embeddableURL = "{$tornURL[0]}//{$tornURL[2]}/embed/{$tornURL[3]}/{$tornURL[4]}?utm_source=oembed{$frameTheme}";
            $height = $theme == 'full' ? 352 : 152;
            echo "
            <iframe 
            src={$embeddableURL}
            width='100%'
            height={$height}
            style='border-radius:12px'
            allowfullscreen 
            allow='clipboard-write; encrypted-media;
            fullscreen; picture-in-picture;'
            loading='lazy'
            frameBorder='0'
            >
            </iframe>
               ";
        }
        // Widget Content Output

        echo $args['after_widget']; // Whatever you want to display after widget (</div>, etc)
    }

    /**
     * Back-end widget form.
     *
     * @see WP_Widget::form()
     *
     * @param array $instance Previously saved values from database.
     */
    public function form($instance)
    {
        $type = !empty($instance['type']) ? $instance['type'] : esc_html__('yt', 'ssb_domain');
        $title = !empty($instance['title']) ? $instance['title'] : esc_html__('من را دنبال کنید', 'ssb_domain');
        $url = !empty($instance['url']) ? $instance['url'] : esc_html__('wordpress', 'ssb_domain');
        $theme = !empty($instance['theme']) ? $instance['theme'] : esc_html__('default', 'ssb_domain');
?>

        <p>
            <label for="<?php echo esc_attr($this->get_field_id('type')); ?>">
                <?php esc_attr_e('نوع:', 'ssb_domain'); ?>
            </label>

            <select class="widefat" id="<?php echo esc_attr($this->get_field_id('type')); ?>" name="<?php echo esc_attr($this->get_field_name('type')); ?>">
                <option value="yt" <?php echo ($type == 'yt') ? 'selected' : ''; ?>>
                    یوتیوب
                </option>
                <option value="sp" <?php echo ($type == 'sp') ? 'selected' : ''; ?>>
                    اسپاتیفای
                </option>
                <option value="gh" <?php echo ($type == 'gh') ? 'selected' : ''; ?>>
                    گیتهاب
                </option>
            </select>
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>">
                <?php esc_attr_e('تیتر:', 'ssb_domain'); ?>
            </label>

            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>">
        </p>

        <p>
            <label for="<?php echo esc_attr($this->get_field_id('url')); ?>">
                <?php esc_attr_e('آدرس:', 'ssb_domain'); ?>
            </label>

            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('url')); ?>" name="<?php echo esc_attr($this->get_field_name('url')); ?>" type="text" value="<?php echo esc_attr($url); ?>">
        </p>

        <p>
            <label for="<?php echo esc_attr($this->get_field_id('theme')); ?>">
                <?php esc_attr_e('تم:', 'ssb_domain'); ?>
            </label>

            <select class="widefat" id="<?php echo esc_attr($this->get_field_id('theme')); ?>" name="<?php echo esc_attr($this->get_field_name('theme')); ?>">
                <option value="default" <?php echo ($theme == 'default') ? 'selected' : ''; ?>>
                    معمولی
                </option>
                <option value="full" <?php echo ($theme == 'full') ? 'selected' : ''; ?>>
                    کامل
                </option>
            </select>
        </p>

<?php
    }

    /**
     * Sanitize widget form values as they are saved.
     *
     * @see WP_Widget::update()
     *
     * @param array $new_instance Values just sent to be saved.
     * @param array $old_instance Previously saved values from database.
     *
     * @return array Updated safe values to be saved.
     */
    public function update($new_instance, $old_instance)
    {
        $instance = array();

        $instance['type'] = (!empty($new_instance['type'])) ? strip_tags($new_instance['type']) : '';
        $instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
        $instance['url'] = (!empty($new_instance['url'])) ? strip_tags($new_instance['url']) : '';
        $instance['theme'] = (!empty($new_instance['theme'])) ? strip_tags($new_instance['theme']) : '';

        return $instance;
    }
} // class Social_Sub_Btns