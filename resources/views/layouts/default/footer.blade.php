<section id="footer-section" class="footer-section">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="section-heading-2">
                    <h3 class="section-title">
                        <span>Office Address</span>
                    </h3>
                </div>
                
                <div class="footer-address">
                    <ul>
                        <li class="footer-contact"><i class="fa fa-home"></i><?php echo cmskey('office_address',true)?></li>
                        <li class="footer-contact"><i class="fa fa-envelope"></i><?php echo cmskey('footer_email')?></li>
                        <li class="footer-contact"><i class="fa fa-phone"><?php echo cmskey('telephone')?></i>

                        </li>
                        
                    </ul>
                </div>
            </div><!--/.col-md-4 -->
            
            <div class="col-md-4">
                <div class="section-heading-2">
                    <h3 class="section-title">
                        <span>Talk to us</span>
                    </h3>
                </div>
                <div class="subscription">
                    {!! Form::open(array('url' => 'Pages/contectus','id'=>'footerContect','name'=>'footerContect','class'=>'form-horizontal')) !!}
                        <div class="form-group">
                            <input name="email" class="form-control" placeholder="Your E-mail" id="email" required="" data-validation-required-message="Please enter your name." type="text">
                            <br/>
                            <textarea name="details" id="footer_detail" class="form-control" placeholder="Your question"></textarea>
                            <br/>
                            <input class="btn btn-primary" value="Subscribe" type="button" onclick="submit_contectUsFooter();">
                        </div>
                    </form>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="section-heading-2">
                    <h3 class="section-title">
                        <span>FLICKR STREAM</span>
                    </h3>
                </div>
                
                <div class="flickr-widget">
                    <ul class="flickr-list">
                        <li>
                            <a href="asset/images/portfolio/img1.jpg" data-lightbox="picture-1">
                                <img src="asset/images/portfolio/img1.jpg" alt="" class="img-responsive">
                            </a>
                        </li>
                        <li>
                            <a href="asset/images/portfolio/img2.jpg" data-lightbox="picture-2">
                                <img src="asset/images/portfolio/img2.jpg" alt="" class="img-responsive">
                            </a>
                        </li>
                        <li>
                            <a href="asset/images/portfolio/img3.jpg" data-lightbox="picture-3">
                                <img src="asset/images/portfolio/img3.jpg" alt="" class="img-responsive">
                            </a>
                        </li>
                        <li>
                            <a href="asset/images/portfolio/img4.jpg" data-lightbox="picture-4">
                                <img src="asset/images/portfolio/img4.jpg" alt="" class="img-responsive">
                            </a>
                        </li>
                        <li>
                            <a href="asset/images/portfolio/img5.jpg" data-lightbox="picture-5">
                                <img src="asset/images/portfolio/img5.jpg" alt="" class="img-responsive">
                            </a>
                        </li>
                        <li>
                            <a href="asset/images/portfolio/img6.jpg" data-lightbox="picture-6">
                                <img src="asset/images/portfolio/img6.jpg" alt="" class="img-responsive">
                            </a>
                        </li>
                        <li>
                            <a href="asset/images/portfolio/img1.jpg" data-lightbox="picture-7">
                                <img src="asset/images/portfolio/img1.jpg" alt="" class="img-responsive">
                            </a>
                        </li>
                        <li>
                            <a href="asset/images/portfolio/img2.jpg" data-lightbox="picture-8">
                                <img src="asset/images/portfolio/img2.jpg" alt="" class="img-responsive">
                            </a>
                        </li>
                    </ul>
                </div>
            </div><!--/.col-md-3 -->
        </div><!--/.row -->
    </div><!-- /.container -->
</section>

<!-- Footer -->
<footer>
    <div class="row" align="center">
        <div class="col-lg-12" >
            <p>Copyright &copy; Muhammad Yousaf</p>
        </div>
    </div>
</footer>
<script type="text/javascript">
     function validateEmail(email){
        var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(email);
    }

    function submit_contectUsFooter(){
        email = $('#email').val().trim();
        if(email == '' || email == 'undefined'){
            alert('Please enter email address');
            return false;
        }
        if(!validateEmail(email)){
            alert('Invalid Email');
            return false;
        }
        detail = $('#footer_detail').val().trim();
        if(detail == ''){
            alert('Please fill in the details');
            return false;
        }
        $('#footerContect').submit();

    }
</script>