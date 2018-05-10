define(['uiComponent', 'ko'], function (Component, ko) {

    return Component.extend({
        initialize: function () {
            var self = this;
            this._super();
            // this.observe(['displayMessage', 'isVisible']);
            // this.observe({
            //     'people':
            //         [{
            //             name: '李白',
            //             age: '30',
            //             sex: '男'
            //         }, {
            //             name: '杜甫',
            //             age: '19',
            //             sex: '男'
            //         }]
            // });
            //
            // var vm = {
            //     isVisible : ko.observable(false),
            //     visibleTest: function () {
            //         this.isVisible(true);
            //     },
            //     inVisibleTest: function () {
            //         this.isVisible(false);
            //     },
            // }
            //
            // this.observe(vm);
            // var isVisible = false;
            this.data = ko.observableArray([
                    {
                        title: 'Q: As a brand-new one, why do I join Super User?',
                        description: 'Super User will have excusive discount codes and rewards.\n' +
                        '    Except these,\n' +
                        '    Super User usually will be the first one to know more about the latest product.\n' +
                        '    Super User may change products of 1byone.',
                        isVisible: ko.observable(false),
                        degree: ko.observable('rotate(-45deg)')

                    },
                    {
                        title: 'Q: Who should apply as a Super User?',
                        description: 'A: Everyone interested in 1byone and active in social media can apply to be a Super User.Some basic\n' +
                        '    requirements for application:\n' +
                        '    Social media— Minimum 20K followers and active engagement\n' +
                        '    YouTube Channel—Minimum 1K subscribers and high-quality content\n' +
                        '    Website / Forum / Blog— Minimum 1K visits daily',
                        isVisible: ko.observable(false),
                        degree: ko.observable('rotate(-45deg)')
                    },
                    {
                        title: 'Q: I have a problem of Super User application?',
                        description: 'A: If you have any problems with Super User, please send an email to <a>ushelp@1byone.com</a> and we\'ll reply back to\n' +
                        '    you within 3 work days.',
                        isVisible: ko.observable(false),
                        degree: ko.observable('rotate(-45deg)')
                    }
                ]);

            // this.isVisible = ko.observable(isVisible);

            this.toggleDes = function (e, index, data) {
                this.isVisible(! this.isVisible());
                this.degree(this.isVisible() ? 'rotate(135deg)': 'rotate(-45deg)');
            };


            // this.observe(['data', 'isVisible']);
        }
    });
});