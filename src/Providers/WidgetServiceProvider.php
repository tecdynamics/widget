<?php

namespace Tec\Widget\Providers;

use Tec\Base\Facades\DashboardMenu;
use Tec\Base\Supports\ServiceProvider;
use Tec\Base\Traits\LoadAndPublishDataTrait;
use Tec\Theme\Events\RenderingAdminBar;
use Tec\Theme\Facades\AdminBar;
use Tec\Widget\Facades\WidgetGroup;
use Tec\Widget\Factories\WidgetFactory;
use Tec\Widget\Models\Widget;
use Tec\Widget\Repositories\Eloquent\WidgetRepository;
use Tec\Widget\Repositories\Interfaces\WidgetInterface;
use Tec\Widget\WidgetGroupCollection;
use Tec\Widget\Widgets\CoreSimpleMenu;
use Tec\Widget\Widgets\Text;
use Illuminate\Contracts\Foundation\Application;

class WidgetServiceProvider extends ServiceProvider
{
    use LoadAndPublishDataTrait;

    public function register(): void
    {
        $this->app->bind(WidgetInterface::class, function () {
            return new WidgetRepository(new Widget());
        });

        $this->app->bind('Tec.widget', function (Application $app) {
            return new WidgetFactory($app);
        });

        $this->app->singleton('Tec.widget-group-collection', function (Application $app) {
            return new WidgetGroupCollection($app);
        });
    }

    public function boot(): void
    {
        $this
            ->setNamespace('packages/widget')
            ->loadAndPublishConfigurations(['permissions'])
            ->loadHelpers()
            ->loadRoutes()
            ->loadMigrations()
            ->loadAndPublishViews()
            ->loadAndPublishTranslations()
            ->publishAssets();

        $this->app->booted(function () {
            WidgetGroup::setGroup([
                'id' => 'primary_sidebar',
                'name' => trans('packages/widget::widget.primary_sidebar_name'),
                'description' => trans('packages/widget::widget.primary_sidebar_description'),
            ]);

            register_widget(CoreSimpleMenu::class);
            register_widget(Text::class);
        });

        DashboardMenu::default()->beforeRetrieving(function () {
            DashboardMenu::make()
                ->registerItem([
                    'id' => 'cms-core-widget',
                    'priority' => 3,
                    'parent_id' => 'cms-core-appearance',
                    'name' => 'packages/widget::widget.name',
                    'route' => 'widgets.index',
                ]);
        });

        $this->app['events']->listen(RenderingAdminBar::class, function () {
            AdminBar::registerLink(
                trans('packages/widget::widget.name'),
                route('widgets.index'),
                'appearance',
                'widgets.index'
            );
        });
    }
}
