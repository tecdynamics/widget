<?php

namespace Tec\Widget\Providers;

use Auth;
use BaseHelper;
use Html;
use Tec\Base\Facades\DashboardMenu;
use Tec\Base\Supports\ServiceProvider;
use Tec\Base\Traits\LoadAndPublishDataTrait;
use Tec\Theme\Events\RenderingAdminBar;
use Tec\Theme\Facades\AdminBar;
use Tec\Theme\Supports\ThemeSupport;
use Tec\Widget\AbstractWidget;
use Tec\Widget\Facades\WidgetGroup;
use Tec\Widget\Factories\WidgetFactory;
use Tec\Widget\Models\Widget;
use Tec\Widget\Repositories\Eloquent\WidgetRepository;
use Tec\Widget\Repositories\Interfaces\WidgetInterface;
use Tec\Widget\WidgetGroupCollection;
use Tec\Widget\Widgets\CoreSimpleMenu;
use Tec\Widget\Widgets\Text;
use Illuminate\Contracts\Foundation\Application;
use Theme;

class WidgetServiceProvider extends ServiceProvider
{
    use LoadAndPublishDataTrait;

    public function register(): void
    {
        $this->app->bind(WidgetInterface::class, function () {
            return new WidgetRepository(new Widget());
        });

        $this->app->bind('tec.widget', function (Application $app) {
            return new WidgetFactory($app);
        });

        $this->app->singleton('tec.widget-group-collection', function (Application $app) {
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

            /*************************/

            $widgetPath = theme_path(Theme::getThemeName() . '/widgets');
            $widgets = BaseHelper::scanFolder($widgetPath);
            if (! empty($widgets) && is_array($widgets)) {
                foreach ($widgets as $widget) {
                    $registration = $widgetPath . '/' . $widget . '/registration.php';
                    if ($this->app['files']->exists($registration)) {
                        $this->app['files']->requireOnce($registration);
                    }
                }
            }

            add_filter('widget_rendered', function (string|null $html, AbstractWidget $widget) {
                if (! setting('show_theme_guideline_link', false) || ! Auth::guard()->check() || ! Auth::guard()->user()->hasPermission('widgets.index')) {
                    return $html;
                }

                $editLink = route('widgets.index') . '?widget=' . $widget->getId();
                $link = view('packages/theme::guideline-link', [
                    'html' => $html,
                    'editLink' => $editLink,
                    'editLabel' => __('Edit this widget'),
                ])->render();

                return ThemeSupport::insertBlockAfterTopHtmlTags($link, $html);
            }, 9999, 2);

            add_filter(THEME_FRONT_HEADER, function ($html) {
                if (! setting('show_theme_guideline_link', false) || ! Auth::guard()->check() || ! Auth::guard()->user()->hasPermission('widgets.index')) {
                    return $html;
                }

                return $html . Html::style('vendor/core/packages/theme/css/guideline.css');
            }, 16);
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
