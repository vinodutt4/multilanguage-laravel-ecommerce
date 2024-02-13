<?php

use Botble\Widget\Models\Widget as WidgetModel;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        WidgetModel::create([
            'widget_id'  => 'NewsletterWidget',
            'sidebar_id' => 'top_footer_sidebar',
            'position'   => 1,
            'data'       => [
                'id'       => 'NewsletterWidget',
                'name'     => 'Sign up to Newsletter',
                'subtitle' => '...and receive $25 coupon for first shopping.',
            ],
            'theme'      => Theme::getThemeName(),
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
