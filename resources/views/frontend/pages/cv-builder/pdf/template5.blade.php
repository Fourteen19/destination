@extends('frontend.pages.cv-builder.pdf.layout.master')

<body style="font-family: serif; font-size:12px">

    <table width="100%" border-width="0" cellpadding="0" cellspacing="0">

        @include('frontend.pages.cv-builder.pdf.blocks.personal-details')

        @include('frontend.pages.cv-builder.pdf.blocks.personal-profile')

    </table>

    @include('frontend.pages.cv-builder.pdf.blocks.employment-skills')

    @include('frontend.pages.cv-builder.pdf.blocks.education')

    @include('frontend.pages.cv-builder.pdf.blocks.additional-interests')

    @include('frontend.pages.cv-builder.pdf.blocks.references')

</body>
