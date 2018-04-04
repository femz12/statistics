<!DOCTYPE html>
<html lang="en">
<!-- BEGIN HEAD -->
<head>
    <meta charset="UTF-8">
    <title>{{config('app.name')}}</title>
    <meta name="csrf_token" content="74647644474647"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="{{asset('css/bootstrap.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('css/fonts/open-sans/styles.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('css/common.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('css/primary.min.css')}}">

</head>
<!-- END HEAD -->
<body class=" ks-sidebar-empty ks-sidebar-fixed ks-theme-primary">

<div class="ks-container">
    <div class="ks-column ks-page">


        <div class="ks-page-content">
            <div class="ks-body mt-0">


                <div class="card-no-border">
                    <div class="card-header"></div>
                    <div class="card-block">
                        <div class="row col-md-12" id="app" get_endpoint="{{asset('js/data.json')}}" post_endpoint="backend/code" quiz_ref_endpoint="{{asset('js/log.json')}}">
                            <component :is="currentView" :quiz_details="quiz_details" transition="fade"
                                       transition-mode="out-in"></component>
                        </div>



                    </div>
                    <div class="card-footer"></div>
                </div>


            </div>
        </div>
    </div>
</div>

<!-- BEGIN PAGE LEVEL PLUGINS -->
<!-- BEGIN SETTINGS BLOCK -->
<footer class=" mt-5">
</footer>

<!-------TEMPLATE------------------>


<!--quiz submission template -->
<template id="quiz-submission-template">

    <div class="row col-md-12">
        <div class="text-center">
            <img src="/app/assets/images/success.png" width="70">
            <h3>Quiz submitted</h3>
            <p class="alert alert-success">Find of the summary of your result below. We have also mailed a copy. It might take a while to arrive.</p>
        </div>
        <table class="table">
            <tbody>
            <tr>
                <th scope="row">Attempt</th>
                <td>@{{result.attempt}}</td>
            </tr>
            <tr>
                <th scope="row">Questions you got Wrong</th>
                <td>@{{result.wrong}}</td>

            </tr>
            <tr>
                <th scope="row">Questions you got right</th>
                <td>@{{result.correct}}</td>

            </tr>
            <tr>
                <th scope="row">Total Number of Questions</th>
                <td>@{{result.total}}</td>

            </tr>
            <tr>
                <th scope="row">Mark</th>
                <td>@{{result.mark}}</td>
            </tr>
            </tbody>
        </table>
    </div>
</template>

<template id="error-response-template">
    <div class="col-md-6 offset-3">
        <div class="card panel border-0 text-center">
            <img src="/app/assets/images/failure_outline.png" width="100" height="100"
                 class="image-responsive"
                 style="margin: 0 auto;"/>
            <h3>An error occurred</h3>
            <div class="alert alert-danger ks-border-active ks-solid-light">
                <p>@{{msg}}</p>
            </div>

        </div>

    </div>

</template>


<!----Quiz ---->
<template id="quiz-template">
    <div class="card row col-md-12">
        <div class="card-header">
            <button class="btn btn-success-outline">Question @{{ current_question+1}} of @{{total_question}}</button>
            <h3 class="text-danger" v-show="is_timed">@{{min}}:@{{sec}}</h3>
        </div>
        <div class="card-block">
            <div class="row col-md-12">
                <div class="col-md-8">
                    <div class="row">
                        <div class="col-md-2">
                            <button v-on:click="prevQuestion" v-show="showPrev"
                                    class="btn btn-primary-outline ks-light mt-3 ks-rounded pull-left">&laquo; Prev
                            </button>
                        </div>
                        <div class="col-md-8">

                            <div v-for="(question, index) in questions" :key="question.Id"
                                 v-show="index==current_question">
                                <div class="row">
                                    <h4 class="ks-text-bold" id=""><span>@{{question.Name}}</span></h4>
                                </div>
                                <div class="text-left options">
                                    <div class="option__container">
                                        <div class="option" v-for="option in question.Options">
                                            <label class="custom-control custom-checkbox" :for="option.Id">
                                                <input :id="option.Id" type="checkbox" class="custom-control-input"
                                                       :value="option.Id" v-model="question.Answered"/>
                                                <span class="custom-control-indicator"></span>
                                                <span class="custom-control-description">@{{option.Name}}</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="text-center">
                                <hr/>
                                <button v-on:click="confirmSubmit" :disabled="submitted"
                                        class="btn btn-primary">Submit Quiz
                                </button>
                            </div>

                        </div>
                        <div class="col-md-2">

                            <button v-on:click="nextQuestion" v-show="showNext" type="button"
                                    class="btn btn-primary-outline mt-3 ks-light ks-rounded pull-right">
                                Next &raquo;</button>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <ul class="options">
                        <li v-for="(question,key) in questions">
                            <button class="btn btn-circle"
                                    :class="QuestionIsAnswered(key)? 'btn-success':'btn-default' " @click="moveTo(key)">
                            Q @{{key+1}}
                            </button>
                        </li>
                    </ul>
                </div>
            </div>

        </div>
    </div>
</template>

@
<template id="loading-template">
    <div class="col-md-4 offset-4">
        <div class="loading">
            <img src="" alt="loading" style="margin:0px auto">
        </div>
    </div>
</template>


<!-------------------TEMPLATE--------------->


</body>
<script src="{{asset('dist/start_quiz.js')}}"></script>
</html>
