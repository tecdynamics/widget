class WidgetManagement {
    init() {
        let listWidgets = [
            {
                name: 'wrap-widgets',
                pull: 'clone',
                put: false,
            },
        ]

        $.each($('.sidebar-item'), () => {
            listWidgets.push({ name: 'wrap-widgets', pull: true, put: true })
        })

        let saveWidget = (parentElement) => {
            if (parentElement.length > 0) {
                let items = []
                $.each(parentElement.find('li[data-id]'), (index, widget) => {
                    items.push($(widget).find('form').serialize())
                })

                Tec.showNotice('info', TecVariables.languages.notices_msg.processing_request)

                $httpClient
                    .make()
                    .post(BWidget.routes.save_widgets_sidebar, {
                        items: items,
                        sidebar_id: parentElement.data('id'),
                    })
                    .then(({ data }) => {
                        parentElement.find('ul').html(data.data)
                        Tec.callScroll($('.list-page-select-widget'))
                        Tec.initResources()
                        Tec.initMediaIntegrate()
                        Tec.showSuccess(data.message)
                    })
                    .finally(() => {
                        parentElement.find('.widget_save i').remove()
                    })
            }
        }

        listWidgets.forEach((groupOpts, i) => {
            Sortable.create(document.getElementById('wrap-widget-' + (i + 1)), {
                sort: i !== 0,
                group: groupOpts,
                delay: 0, // time in milliseconds to define when the sorting should start
                disabled: false, // Disables the sortable if set to true.
                store: null, // @see Store
                animation: 150, // ms, animation speed moving items when sorting, `0` — without animation
                handle: '.widget-handle',
                ghostClass: 'sortable-ghost', // Class name for the drop placeholder
                chosenClass: 'sortable-chosen', // Class name for the chosen item
                dataIdAttr: 'data-id',

                forceFallback: false, // ignore the HTML5 DnD behaviour and force the fallback to kick in
                fallbackClass: 'sortable-fallback', // Class name for the cloned DOM Element when using forceFallback
                fallbackOnBody: false, // Appends the cloned DOM Element into the Document's Body

                scroll: true, // or HTMLElement
                scrollSensitivity: 30, // px, how near the mouse must be to an edge to start scrolling.
                scrollSpeed: 10, // px

                // Changed sorting within list
                onUpdate: (evt) => {
                    if (evt.from !== evt.to) {
                        saveWidget($(evt.from).closest('.sidebar-item'))
                    }
                    saveWidget($(evt.item).closest('.sidebar-item'))
                },
                onAdd: (evt) => {
                    if (evt.from !== evt.to) {
                        saveWidget($(evt.from).closest('.sidebar-item'))
                    }
                    saveWidget($(evt.item).closest('.sidebar-item'))
                },
            })
        })

        let widgetWrap = $('#wrap-widgets')
        widgetWrap.on('click', '.widget-control-delete', (event) => {
            event.preventDefault()
            let _self = $(event.currentTarget)

            let widget = _self.closest('li')
            _self.addClass('button-loading')

            Tec.showNotice('info', TecVariables.languages.notices_msg.processing_request)

            $httpClient
                .make()
                .delete(BWidget.routes.delete, {
                    widget_id: widget.data('id'),
                    position: widget.data('position'),
                    sidebar_id: _self.closest('.sidebar-item').data('id'),
                })
                .then(({ data }) => {
                    Tec.showSuccess(data.message)
                    widget.fadeOut().remove()
                })
                .finally(() => {
                    widget.find('.widget-control-delete').removeClass('button-loading')
                })
        })

        widgetWrap.on('click', '#added-widget .widget-handle', (event) => {
            let _self = $(event.currentTarget)
            _self.closest('li').find('.widget-content').slideToggle(300)
            _self.find('.fa').toggleClass('fa-caret-up')
            _self.find('.fa').toggleClass('fa-caret-down')
        })

        widgetWrap.on('click', '#added-widget .sidebar-header', (event) => {
            let _self = $(event.currentTarget)
            _self.closest('.sidebar-area').find('> ul').slideToggle(300)
            _self.find('.fa').toggleClass('fa-caret-up')
            _self.find('.fa').toggleClass('fa-caret-down')
        })

        widgetWrap.on('click', '.widget_save', (event) => {
            event.preventDefault()
            let _self = $(event.currentTarget)
            _self.addClass('button-loading')
            saveWidget(_self.closest('.sidebar-item'))
        })

        Tec.callScroll($('.list-page-select-widget'))
    }
}

$(document).ready(() => {
    new WidgetManagement().init()
})
