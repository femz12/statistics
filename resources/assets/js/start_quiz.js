import Vue from "vue";
import VueRouter from "vue-router";
import VueResource from "vue-resource";
Vue.use(VueRouter);
Vue.use(VueResource);
Vue.component('quiz-component', {
    template: '#quiz-template',
    props: ['quiz_details'],

    data: function () {
        return {
            current_question: 0,
            showPrev: false,
            showNext: true,
            showSubmit: false,
            submitted: false,
            minute: 0,
            second: 0,
            quiz: this.quiz_details.quiz,
            questions: this.quiz_details.questions,
            config: this.quiz_details.config,
            total_question: this.quiz_details.questions.length,
            is_timed: this.quiz_details.config.is_timed,
            duration: this.quiz_details.config.time,

        }
    },

    created: function () {
        if (this.is_timed) {
            //start timer automatically
            this.startTimer();
        }
    },
    computed: {
        min: function () {
            if (this.minute < 10) {
                return '0' + this.minute
            }
            return this.minute;
        },
        sec: function () {
            if (this.second < 10) {
                return '0' + this.second;
            }
            return this.second;
        }
    },
    methods: {
        prevQuestion: function () {
            if (this.current_question > 0) {
                this.current_question = this.current_question - 1;
            }
            this.toggleBtnVisibility();
        },
        nextQuestion: function () {
            var lastquestion = this.total_question - 1;
            if (this.current_question < lastquestion) {
                this.current_question = this.current_question + 1;
            }
            this.toggleBtnVisibility();

        },
        toggleBtnVisibility: function () {
            var page = this.current_question;
            var total = this.total_question - 1;
            if (page > 0 && page < total) {
                this.showNext = true;
                this.showPrev = true;
            }
            if (page == 0) {
                this.showNext = true;
                this.showPrev = false;
            }

            if (page == total) {
                this.showNext = false;
                this.showPrev = true;
                this.showSubmit = true;
            }

        },

        startTimer: function () {
            var time = this.duration;
            time = new Date(time * 1000);
            this.minute = time.getMinutes();
            this.second = time.getSeconds();
            this.interval = setInterval(this.tick, 1000);
        },
        tick: function () {
            if (this.second > 0) {
                this.second--;
                return;
            }
            if (this.second == 0 && this.minute > 0) {
                this.minute--
                this.second = 59;
                return;
            }
            if (this.minute == 0 && this.second == 0) {
                //time up;
                //this.submitQuiz();
                clearInterval(this.interval);
                this.submit();
                return;
            }
        },
        confirmSubmit: function () {
            var result = confirm("Are you sure you want to submit?");
            if (result) {
                this.submit();
            }
            return;
        },
        submit: function () {
            if(this.submitted){
                //quiz was submitted submitted
                return;
            }
            this.submitted=true;
            var answers = [];
            var time = this.minute + ':' + this.second
            this.questions.forEach(function (q, index) {
                answers.push({'question_id': q.Id, 'option_id': JSON.stringify(q.Answered)});
            })
            var params = {'quiz_id': this.quiz.Id, 'questions': answers, time: time, log_id: null};
            this.$parent.submitQuiz(params);
        },
        moveTo: function (index) {
            this.current_question = index;
        },
        QuestionIsAnswered: function (index) {
            var ans = this.questions[index].Answered;
            if (ans.length > 0) {
                return true;
            }
            return false;
        }

    }
});


Vue.component('loading-component', {
    template: '#loading-template',
})
Vue.component('error-response-component', {
    template: '#error-response-template',
    props: ['msg']
})

Vue.component('success-response-component', {
    template: '#quiz-submission-template',
    props:['result']
});

Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf_token"]').getAttribute('content'); //add token;
var dom = document.getElementById("app");
var data = {
    quiz_details: null,
    currentView: 'loading-component',
    get_data_url: dom.getAttribute("get_endpoint"),
    post_data_url: dom.getAttribute("post_endpoint"),
    log_data_url: dom.getAttribute("quiz_ref_endpoint"),
    log_id: null,
    msg: null,
    result:null,
}

new Vue({
    el: '#app',
    data: data,
    created: function () {
        if (this.get_data_url != null)
            this.getQuiz(); //get quiz
    },

    methods: {
        changeComponent: function (view) {
            this.currentView = view;
        },

        submitQuiz: function (params) {

            params.log_id = this.log_id;
            console.log(params);
            this.changeComponent('loading-component');
            this.$http.post(this.post_data_url, params).then(function (response) {
                var response = JSON.parse(response.bodyText);
                if (response.status == true) {
                    this.result=response.data; // get data from the backend
                    this.changeComponent('success-response-component');
                } else {
                    this.msg = response.msg;
                    this.changeComponent('error-response-component');
                }
            });
        },
        getQuiz: function () {
            this.$http.get(this.get_data_url).then(function (response) {
                var response = JSON.parse(response.bodyText);
                if (response.status == true) {
                    console.log(response.data);
                    this.quiz_details = response.data;
                    console.log(this.quiz_details);
                    this.changeComponent('quiz-component');
                    this.quizIsLoaded(response.data.quiz.Id);
                } else {
                    console.log('Component not loaded');
                }
            })
        },
        quizIsLoaded: function (id) {
            var params = {quiz_id: id};
            console.log('logging quiz')
            this.$http.post(this.log_data_url, params).then(function (response) {
                var response = JSON.parse(response.bodyText);
                console.log(response);
                console.log('quiz is loaded');
                if (response.status == true) {
                    this.log_id = response.log_id;
                }
            })
        }
    }
})
