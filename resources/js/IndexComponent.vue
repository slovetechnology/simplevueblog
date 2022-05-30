<template>
<div>
    <router-view></router-view>
</div>

</template>
<script>


export default {
    methods: {
    }
}

</script>
<style>
.boxopendiv {
    display: none;
}
body {
    overflow-x: hidden;
}
.row>div{
    padding: 0;
    margin: 0;
}
.maindiv{
    width: 100%;
    height: 91.7vh;
    overflow: hidden;
}
.centerdiv{
    height: 91.7vh;
    overflow-y: auto;
    overflow-x: hidden;
}
.centerdiv::-webkit-scrollbar{
    width: 6px;
}
.no-text{
    text-decoration: none;
}
.cursor-pointer{
    cursor: pointer;
}
.centerdiv::-webkit-scrollbar-thumb{
    width: 6px;
    background: grey;
    border-radius: 20px;
}
.mainheader{
    background: rgb(33, 64, 90);
}
.no-text{
    text-decoration: none;
}
.links{
    color: lightgrey;
    cursor: pointer;
    padding: 7px 7px;
}
form{
    position: relative;
}
form>i{
    position: absolute;
    top: 0;
    left: 0;
    cursor: text;
}
.links:hover{
    background: lightgrey;
    border-radius: 50%;
    transition: color .5s ease;
    color: rgb(33, 64, 90);
}
.font-size-18px {
    font-size: 18px;
}
.extrahd {
    position: absolute;
    top: 8%;
    right: 2%;
    background: #fff;
    display: none;
    transition: display 1s ease;
}
.extrahdlink {
    display: block;
    text-decoration: none;
    color: #222;
    padding: 5px 38px 5px 10px;
    text-transform: capitalize;
    font-size: 16px;
    border-bottom: 1px solid rgb(199, 197, 197);
}
.extrahdlink:last-child {
    border: none;
}
.extrahdlink:hover {
    background: rgb(241, 241, 241);
    color: #222;
}
.overlay {
    display: none;
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100vh;
    z-index: 10;
    align-items: center;
    justify-content: center;
    background: rgba(0, 0, 0, 0.681);
}
.w-350px {
    width: 350px;
}
.formers2 {
    position: absolute;
    top: 0;
    left: 0;
}
@media screen and (max-width: 768px) {
    .formers {
        display: none;
    }
}
@media screen and (min-width: 768px) {
    .formers2 {
        display: none;
    }
}

</style>
