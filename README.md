<snippet>
  <content><![CDATA[
# ${1:Project Name}
 
Php classes for calling social counts api on multiple URLS
 
## Installation
 
Packagist : https://packagist.org/packages/kcassam/urls-analytics
 
## Usage
 
## Test

    cd src/UrlsAnalytics/ApiCalls/
    php test.php

## Test Result

    $ php test.php
    Welcome to Test....Array
    (
        [http://google.com] => Array
            (
                [StumbleUpon] => 208000
                [Reddit] => 0
                [Facebook] => Array
                    (
                        [commentsbox_count] => 10118
                        [click_count] => 265614
                        [total_count] => 10151403
                        [comment_count] => 1812801
                        [like_count] => 1579262
                        [share_count] => 6759340
                    )
    
                [Delicious] => 0
                [GooglePlusOne] => 9784545
                [Buzz] => 0
                [Twitter] => 11424
                [Diggs] => 0
                [Pinterest] => 11278
                [LinkedIn] => 0
            )
    
        [http://headoo.com] => Array
            (
                [StumbleUpon] => 0
                [Reddit] => 0
                [Facebook] => Array
                    (
                        [commentsbox_count] => 0
                        [click_count] => 0
                        [total_count] => 27
                        [comment_count] => 3
                        [like_count] => 7
                        [share_count] => 17
                    )
    
                [Delicious] => 0
                [GooglePlusOne] => 24
                [Buzz] => 0
                [Twitter] => 28
                [Diggs] => 0
                [Pinterest] => 0
                [LinkedIn] => 11
            )
    
        [http://facebook.com] => Array
            (
                [StumbleUpon] => 114000
                [Reddit] => 0
                [Facebook] => Array
                    (
                        [commentsbox_count] => 1345
                        [click_count] => 0
                        [total_count] => 17744262
                        [comment_count] => 5167399
                        [like_count] => 4900993
                        [share_count] => 7675870
                    )
    
                [Delicious] => 0
                [GooglePlusOne] => 40525
                [Buzz] => 0
                [Twitter] => 66120
                [Diggs] => 0
                [Pinterest] => 4527
                [LinkedIn] => 0
            )
    
        [BAD_FORMATTED_URL] => Array
            (
                [error] => Exception Object
                    (
                        [message:protected] => file_get_contents(https://free.sharedcount.com/?url=BAD_FORMATTED_URL&apikey=9bedf9c6d2d465349350ae938c91b8bfb508073a) is false
                        [string:Exception:private] => 
                        [code:protected] => 0
                        [file:protected] => /Users/ka/Repositories/kcassam/urls-analytics/src/UrlsAnalytics/ApiCalls/ApiCalls.php
                        [line:protected] => 62
                        [trace:Exception:private] => Array
                            (
                                [0] => Array
                                    (
                                        [file] => /Users/ka/Repositories/kcassam/urls-analytics/src/UrlsAnalytics/ApiCalls/test.php
                                        [line] => 20
                                        [function] => get
                                        [class] => UrlsAnalytics\ApiCalls\ApiCalls
                                        [type] => ->
                                        [args] => Array
                                            (
                                                [0] => Array
                                                    (
                                                        [0] => http://google.com
                                                        [1] => http://headoo.com
                                                        [2] => http://facebook.com
                                                        [3] => BAD_FORMATTED_URL
                                                    )
    
                                            )
    
                                    )
    
                            )
    
                        [previous:Exception:private] => 
                    )
    
            )
    
    )
    
    FIN


 
## Contributing
 
1. Fork it!
2. Create your feature branch: `git checkout -b my-new-feature`
3. Commit your changes: `git commit -am 'Add some feature'`
4. Push to the branch: `git push origin my-new-feature`
5. Submit a pull request :D
 
## History
 
TODO: Write history
 
## Credits
 
TODO: Write credits
 
## License
 
TODO: Write license
]]></content>
  <tabTrigger>readme</tabTrigger>
</snippet>
