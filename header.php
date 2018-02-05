<?php
return "
<!DOCTYPE HTML>
<html>
    <head>
        <style>
            * {box-sizing: border-box;}
            .wrapper {
                max-width: 940px;
                margin: 0 auto;
            }
            .wrapper > div {
                border: 2px solid rgb(233,171,88);
                border-radius: 5px;
                background-color: rgba(233,171,88,.5);
                padding: 1em;
                color: #d9480f;
                position: relative;
            }.wrapper {
                display: grid;
                grid-template-columns: repeat(3, 130px);
                grid-gap: 10px;
                grid-auto-rows: minmax(100px, auto);
            }
            p {
                position: absolute;
                margin: 0;
                width: 100%;
                left: 0px;
                padding: 20px;
            }
            .center {
                top: 50%;
                transform: translateY(-50%);
            }
            .top {
                top: 0px;
            }
            .bottom {
                bottom: 0px;
            }

        </style>
    </head>
    <body>
        <div class='wrapper'>
";
