@extends('frontend.pages.cv-builder.pdf.layout.master')

<body style="font-family: helvetica; font-size:14px">

    <table width="100%" border-width="0" cellpadding="0" cellspacing="0">

        @include('frontend.pages.cv-builder.pdf.blocks.personal-details')

        @include('frontend.pages.cv-builder.pdf.blocks.personal-profile')

        @include('frontend.pages.cv-builder.pdf.blocks.employment-skills')

    </table>

    @include('frontend.pages.cv-builder.pdf.blocks.employment-history', ['block_title' => "Employment history"])

    @include('frontend.pages.cv-builder.pdf.blocks.education')

    @include('frontend.pages.cv-builder.pdf.blocks.additional-interests')

    @include('frontend.pages.cv-builder.pdf.blocks.references')

</body>
