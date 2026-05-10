<?php if(!isset($pageTitle)) $pageTitle = 'GymTrack'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?> - GymTrack</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: lightgray;
        }

        footer {
            color: gray;
            font-size: 13px;
        }

        pre {
            background-color: white;
            padding: 15px;
            border-radius: 6px;
            font-size: 13px;
        }

        .table thead th {
            background-color: black;
            color: white;
        }
    </style>
</head>
<body>