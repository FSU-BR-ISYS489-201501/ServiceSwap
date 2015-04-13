<!-- Begin NavBar -->
<div class="navbar navbar-inverse navbar-static-top" role="navigation">
    <div class="container">
        <!--content for mobile tabs eventually-->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".menu2">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <!--End of mobile tabs-->
            <!--holds left side of NavBar-->
            <span class="navbar-brand" href="#"><img src="img/logo.png" width="210" height="50" alt="My Logo"></span>
        </div>

        <!--End of left side NavBar-->
        <!-- Modal -->
        <div class="modal fade" id="myModal1" tabindex="1" role="dialog" aria-labelledby="myModalLabel"
             aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

                    </div>
                    <div class="modal-body">
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs">
                            <li><a href="#2" data-toggle="tab">Create Account</a></li>
                            <li class="active"><a href="#1" data-toggle="tab">Log In</a></li>


                        </ul>

                        <!-- Tab panes -->
                        <div class="tab-content">
                            <!-- this is the Tab for registration of a user -->
                            <div class="tab-pane" id="2">
                                <div class="row">


                                    <br><br><br><br>
                                    <form action="Resources/Php/Register.php" method="post">
                                    <div class="col-md-10">
                                        <div class="input-group">
                                            <span class="input-group-addon" id="basic-addon1">First name</span>
                                            <input type="text" name="FirstName" class="form-control" placeholder=""
                                                   aria-describedby="basic-addon1">
                                        </div>
                                        <br>

                                        <div class="input-group">
                                            <span class="input-group-addon" id="basic-addon1">Last name</span>
                                            <input type="text" name="LastName" class="form-control" placeholder=""
                                                   aria-describedby="basic-addon1">
                                        </div>
                                        <br>

                                        <div class="input-group">
                                            <span class="input-group-addon" id="basic-addon1">Username</span>
                                            <input type="text" name="UserName" class="form-control" placeholder=""
                                                   aria-describedby="basic-addon1">
                                        </div>
                                        <br>

                                        <div class="input-group">
                                            <span class="input-group-addon" id="basic-addon1">Address</span>
                                            <input type="text" name="Address" class="form-control" placeholder=""
                                                   aria-describedby="basic-addon1">
                                        </div>
                                        <br>

                                        <div class="input-group">
                                            <span class="input-group-addon" id="basic-addon1">Email</span>
                                            <input type="text" name="Email" class="form-control" placeholder=""
                                                   aria-describedby="basic-addon1">
                                        </div>
                                        <br>
                                        <div class="input-group">
                                            <span class="input-group-addon" id="basic-addon1">Retype Email</span>
                                            <input type="text" name="ReEmail" class="form-control" placeholder=""
                                                   aria-describedby="basic-addon1">
                                        </div>
                                        <br>
                                        <div class="input-group">
                                            <span class="input-group-addon" id="basic-addon1">Birthday</span>
                                            <input type="text" name="Birthday" class="form-control" placeholder=""
                                                   aria-describedby="basic-addon1">
                                        </div>
                                        <br>
                                        <div class="input-group">
                                            <span class="input-group-addon" id="basic-addon1">Password</span>
                                            <input type="password" name="Password" class="form-control" placeholder=""
                                                   aria-describedby="basic-addon1">
                                        </div>
                                        <br>
                                        <div class="input-group">
                                            <span class="input-group-addon" id="basic-addon1">Retype password</span>
                                            <input type="password" name="RePassword" class="form-control" placeholder=""
                                                   aria-describedby="basic-addon1">
                                        </div>
                                        <br>
                                        <div class="input-group">
                                            <span class="input-group-addon" id="basic-addon1">Phone number</span>
                                            <input type="text" name="Phone" class="form-control" placeholder=""
                                                   aria-describedby="basic-addon1">
                                        </div>
                                        <br>

                                        <div class="input-group">
                                            <span class="input-group-addon" id="basic-addon1">Prefered method of communication</span>
                                            <input type="text" name="Method" class="form-control" placeholder=""
                                                   aria-describedby="basic-addon1">
                                        </div>
                                        <br>






                                        <div class="row">
                                            <div class="col-md-4">
                                                <input id="submit" name="submit" type="submit" value="Send" class="btn btn-primary">
                                            </div>
                                            <div class="col-md-4"></div>
                                            <div class="col-md-4"></div>
                                        </div>


                                    </div>
                                        </form>
                                    <br><br><br><br><br><br>


                                    <br><br><br><br><br><br>

                                </div>

                            </div>
                            <!--End User Reg tab-->

                            <!-- This is the tab for a user to log in-->
                            <div class="tab-pane active" id="1">
                                <div class="row">


                                    <br><br><br><br>

                                    <div class="col-md-10">
                                        <div class="input-group">
                                            <span class="input-group-addon" id="basic-addon1">Username</span>
                                            <input type="text" class="form-control" placeholder=""
                                                   aria-describedby="basic-addon1" id="email">
                                        </div>
                                        <br>

                                        <div class="input-group">
                                            <span class="input-group-addon" id="basic-addon1">Password</span>
                                            <input type="text" class="form-control" placeholder=""
                                                   aria-describedby="basic-addon1" id="pass">
                                        </div>
                                        <br>

                                        <div class="row">
                                            <div class="col-md-4">
                                                <button type="button" class="btn btn-primary">Submit</button>
                                            </div>
                                            <div class="col-md-4"></div>
                                            <div class="col-md-4"><a href="#">Forget Password?</a></div>
                                        </div>


                                    </div>
                                    <br><br><br><br><br><br>


                                    <br><br><br><br><br><br>

                                </div>


                            </div>
                            <!--End log in tab-->


                        </div>
                    </div>

                </div>
            </div>
        </div>
        <!--End of Model-->
        <!--This is the right side of the NavBar that holds both search and log in-->
        <div class="navbar-collapse collapse menu2">

            <ul class="nav navbar-nav navbar-right">
                <li><a href="#myModal1" data-toggle="modal">Log In</a></li>

            </ul>
            <div class="col-sm-3 col-md-3 pull-right">
                <form class="navbar-form" role="search">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Search" name="srch-term" id="srch-term">

                        <div class="input-group-btn">
                            <button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i>
                            </button>

                        </div>
                    </div>
                </form>

            </div>


        </div>
        <!--End of right side NavBar-->
        <!--/.nav-collapse -->


    </div>
</div>