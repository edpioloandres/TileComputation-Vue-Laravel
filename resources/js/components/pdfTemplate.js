import { PDFDocument, rgb } from "pdf-lib"
import fontkit from "@pdf-lib/fontkit"
import { degrees } from 'pdf-lib'

export default class printPdf{
    
    constructor(data, gaiheki, today, tileKind, option, service, demado, balcony, columnPoints, columnData, balconyData, demadoData, doorData, sashData, jikuPoints, wakuPoints) {
        this.data = data;
        this.gaiheki = gaiheki;
        this.today = today;
        this.tileKind = tileKind;
        this.option = option;
        this.service = service;
        this.demado = demado;
        this.balcony = balcony;
        this.columnPoints = columnPoints;
        this.columnData = columnData;
        this.balconyData = balconyData;
        this.demadoData = demadoData;
        this.doorData = doorData;
        this.sashData = sashData;
        this.jikuPoints = jikuPoints;
        this.wakuPoints = wakuPoints;

        this.totalTile = this.option + this.service

        if(this.jikuPoints !== 0){
            this.otherPoints = jikuPoints.toString()
        }else if(this.wakuPoints !== 0){
            this.otherPoints = wakuPoints.toString()
        }else{
            this.otherPoints = "-"
        }
    }

    async print(){
        const template1 = 'http://hrdapps58:8888/ftp/systemlogo/gaiheki-report-revised.pdf'
        const template2 = 'http://hrdapps58:8888/ftp/systemlogo/tile-summary.pdf'
      
        const firstPdfBytes = await fetch(template1).then(res => res.arrayBuffer())
        const secondPdfBytes = await fetch(template2).then(res => res.arrayBuffer())
      
        const firstPdfDoc = await PDFDocument.load(firstPdfBytes)
        const secondPdfDoc = await PDFDocument.load(secondPdfBytes)
      
        const pdfDoc = await PDFDocument.create();
      
        const [file1] = await pdfDoc.copyPages(firstPdfDoc, [0])
        const [file2] = await pdfDoc.copyPages(secondPdfDoc, [0])
      
        pdfDoc.addPage(file1)
        pdfDoc.insertPage(1, file2)

        const urlFont = "http://hrdapps58:8888/ftp/systemlogo/MS-Gothic.ttf";
        const fontBytes = await fetch(urlFont).then((res) => res.arrayBuffer());
        
        pdfDoc.registerFontkit(fontkit);

        const customFont = await pdfDoc.embedFont(fontBytes);

        const pages = pdfDoc.getPages();
        const page1 = pages[0];
        const page2 = pages[1];

        ///////////////////////////////////////////////////////////// PAGE 1 /////////////////////////////////////////////////////////////

        //////////////////////////// basic info ////////////////////////////

        page1.drawText(this.today, {
            x: 570,
            y: 27,
            size: 9.5,
            font: customFont,
            rotate: degrees(90),
        })

        page1.drawText(this.data.customerCode, {
            x: 65,
            y: 105,
            size: 11,
            font: customFont,
            rotate: degrees(90),
        })

        page1.drawText(this.data.customerName, {
            x: 65,
            y: 345,
            size: 11,
            font: customFont,
            rotate: degrees(90),
        })

        page1.drawText(this.data.customerRoman, {
            x: 65,
            y: 620,
            size: 11,
            font: customFont,
            rotate: degrees(90),
        })

        page1.drawText(this.data.planNo, {
            x: 107,
            y: 65,
            size: 11,
            font: customFont,
            rotate: degrees(90),
        })

        if(this.data.houseType == "i-smart" || this.data.houseType == "i-cube"){
            page1.drawText(this.data.houseType, {
                x: 107,
                y: 205,
                size: 11,
                font: customFont,
                rotate: degrees(90),
            })
        }else if(this.data.houseType == "i-smile＋"){
            page1.drawText(this.data.houseType, {
                x: 107,
                y: 200,
                size: 11,
                font: customFont,
                rotate: degrees(90),
            })
        }else if(this.data.houseType == "i-smile(2×6)"){
            page1.drawText(this.data.houseType, {
                x: 107,
                y: 190,
                size: 11,
                font: customFont,
                rotate: degrees(90),
            })
        }else if(this.data.houseType == "洋風セゾンＡ３"){
            page1.drawText(this.data.houseType, {
                x: 107,
                y: 185,
                size: 11,
                font: customFont,
                rotate: degrees(90),
            })
        }else if(this.data.houseType == "洋風セゾンＦ２"){
            page1.drawText(this.data.houseType, {
                x: 107,
                y: 185,
                size: 11,
                font: customFont,
                rotate: degrees(90),
            })
        }else if(this.data.houseType == "洋風セゾンＦ２‐ＴＤ"){
            page1.drawText(this.data.houseType, {
                x: 107,
                y: 160,
                size: 11,
                font: customFont,
                rotate: degrees(90),
            })
        }else if(this.data.houseType == "洋風ブリアール"){
            page1.drawText(this.data.houseType, {
                x: 107,
                y: 185,
                size: 11,
                font: customFont,
                rotate: degrees(90),
            })
        }else if(this.data.houseType == "和風百年Ｆ２"){
            page1.drawText(this.data.houseType, {
                x: 107,
                y: 190,
                size: 11,
                font: customFont,
                rotate: degrees(90),
            })
        }else{
            page1.drawText(this.data.houseType, {
                x: 107,
                y: 150,
                size: 11,
                font: customFont,
                rotate: degrees(90),
            })
        }

        // page1.drawText(this.data.houseType, {
        //     x: 107,
        //     y: 240,
        //     size: 11,
        //     font: customFont,
        //     rotate: degrees(90),
        // })

        page1.drawText(this.data.contractDate.replace(/\\|\//g,''), {
            x: 107,
            y: 333,
            size: 11,
            font: customFont,
            rotate: degrees(90),
        })

        page1.drawText(this.data.joutoDate.replace(/\\|\//g,''), {
            x: 107,
            y: 406,
            size: 11,
            font: customFont,
            rotate: degrees(90),
        })

        page1.drawText(this.data.ihead, {
            x: 107,
            y: 497,
            size: 11,
            font: customFont,
            rotate: degrees(90),
        })

        page1.drawText('910', {
            x: 107,
            y: 567,
            size: 11,
            font: customFont,
            rotate: degrees(90),
        })

        page1.drawText(this.data.kanabakari, {
            x: 107,
            y: 640,
            size: 11,
            font: customFont,
            rotate: degrees(90),
        })

        page1.drawText(this.otherPoints, {
            x: 107,
            y: 716,
            size: 11,
            font: customFont,
            rotate: degrees(90),
        })

        ///////////////////////////////////////////////////////////// GAIHEKI AREA /////////////////////////////////////////////////////////////

        //////////////////////////// east ////////////////////////////
        if(this.gaiheki[0].HWgrid !== null){
            if((this.gaiheki[0].HWgrid * 0.91).toString().length == 5){
                page1.drawText((this.gaiheki[0].HWgrid * 0.91).toString(), {
                    x: 160,
                    y: 141,
                    size: 10,
                    font: customFont,
                    rotate: degrees(90),
                })
            }else if((this.gaiheki[0].HWgrid * 0.91).toString().length == 1){
                page1.drawText((this.gaiheki[0].HWgrid * 0.91).toString(), {
                    x: 160,
                    y: 161,
                    size: 10,
                    font: customFont,
                    rotate: degrees(90),
                })
            }else{
                page1.drawText((this.gaiheki[0].HWgrid * 0.91).toString(), {
                    x: 160,
                    y: 146,
                    size: 10,
                    font: customFont,
                    rotate: degrees(90),
                })
            }
        }

        if(this.gaiheki[0].HWpoint !== null){
            if((this.gaiheki[0].HWpoint).toString().length == 5){
                page1.drawText((this.gaiheki[0].HWpoint).toString(), {
                    x: 177,
                    y: 141,
                    size: 10,
                    font: customFont,
                    rotate: degrees(90),
                })
            }else if((this.gaiheki[0].HWpoint).toString().length == 1){
                page1.drawText((this.gaiheki[0].HWpoint).toString(), {
                    x: 177,
                    y: 161,
                    size: 10,
                    font: customFont,
                    rotate: degrees(90),
                })
            }else{
                page1.drawText((this.gaiheki[0].HWpoint).toString(), {
                    x: 177,
                    y: 146,
                    size: 10,
                    font: customFont,
                    rotate: degrees(90),
                })
            }
        }

        if(this.gaiheki[0].LWgrid !== null){
            if((this.gaiheki[0].LWgrid * 0.91).toString().length == 5){
                page1.drawText((this.gaiheki[0].LWgrid * 0.91).toString(), {
                    x: 194,
                    y: 141,
                    size: 10,
                    font: customFont,
                    rotate: degrees(90),
                })
            }else if((this.gaiheki[0].LWgrid * 0.91).toString().length == 1){
                page1.drawText((this.gaiheki[0].LWgrid * 0.91).toString(), {
                    x: 194,
                    y: 161,
                    size: 10,
                    font: customFont,
                    rotate: degrees(90),
                })
            }else{
                page1.drawText((this.gaiheki[0].LWgrid * 0.91).toString(), {
                    x: 194,
                    y: 146,
                    size: 10,
                    font: customFont,
                    rotate: degrees(90),
                })
            }
        }

        if(this.gaiheki[0].LWpoint !== null){
            if((this.gaiheki[0].LWpoint).toString().length == 5){
                page1.drawText((this.gaiheki[0].LWpoint).toString(), {
                    x: 211,
                    y: 141,
                    size: 10,
                    font: customFont,
                    rotate: degrees(90),
                })
            }else if((this.gaiheki[0].LWpoint).toString().length == 1){
                page1.drawText((this.gaiheki[0].LWpoint).toString(), {
                    x: 211,
                    y: 161,
                    size: 10,
                    font: customFont,
                    rotate: degrees(90),
                })
            }else{
                page1.drawText((this.gaiheki[0].LWpoint).toString(), {
                    x: 211,
                    y: 146,
                    size: 10,
                    font: customFont,
                    rotate: degrees(90),
                })
            }
        }

        if(this.gaiheki[0].totalSTC !== null){
            if((this.gaiheki[0].totalSTC).toString().length == 5){
                page1.drawText((this.gaiheki[0].totalSTC).toString(), {
                    x: 227,
                    y: 141,
                    size: 10,
                    font: customFont,
                    rotate: degrees(90),
                })
            }else if((this.gaiheki[0].totalSTC).toString().length == 1){
                page1.drawText((this.gaiheki[0].totalSTC).toString(), {
                    x: 227,
                    y: 161,
                    size: 10,
                    font: customFont,
                    rotate: degrees(90),
                })
            }else{
                page1.drawText((this.gaiheki[0].totalSTC).toString(), {
                    x: 227,
                    y: 146,
                    size: 10,
                    font: customFont,
                    rotate: degrees(90),
                })
            }
        }

        if((this.gaiheki[0].finalPoint).toString().length == 5){
            page1.drawText((this.gaiheki[0].finalPoint).toString(), {
                x: 243,
                y: 141,
                size: 10,
                font: customFont,
                rotate: degrees(90),
            })
        }else if((this.gaiheki[0].finalPoint).toString().length == 1){
            page1.drawText((this.gaiheki[0].finalPoint).toString(), {
                x: 243,
                y: 161,
                size: 10,
                font: customFont,
                rotate: degrees(90),
            })
        }else{
            page1.drawText((this.gaiheki[0].finalPoint).toString(), {
                x: 243,
                y: 152,
                size: 10,
                font: customFont,
                rotate: degrees(90),
            })
        }

        //////////////////////////// south ////////////////////////////

        if(this.gaiheki[1].HWgrid !== null){
            if((this.gaiheki[1].HWgrid * 0.91).toString().length == 5){
                page1.drawText((this.gaiheki[1].HWgrid * 0.91).toString(), {
                    x: 160,
                    y: 288,
                    size: 10,
                    font: customFont,
                    rotate: degrees(90),
                })
            }else if((this.gaiheki[1].HWgrid * 0.91).toString().length == 1){
                page1.drawText((this.gaiheki[1].HWgrid * 0.91).toString(), {
                    x: 160,
                    y: 308,
                    size: 10,
                    font: customFont,
                    rotate: degrees(90),
                })
            }else{
                page1.drawText((this.gaiheki[1].HWgrid * 0.91).toString(), {
                    x: 160,
                    y: 293,
                    size: 10,
                    font: customFont,
                    rotate: degrees(90),
                })
            }
        }

        if(this.gaiheki[1].HWpoint !== null){
            if((this.gaiheki[1].HWpoint).toString().length == 5){
                page1.drawText((this.gaiheki[1].HWpoint).toString(), {
                    x: 177,
                    y: 288,
                    size: 10,
                    font: customFont,
                    rotate: degrees(90),
                })
            }else if((this.gaiheki[1].HWpoint).toString().length == 1){
                page1.drawText((this.gaiheki[1].HWpoint).toString(), {
                    x: 177,
                    y: 308,
                    size: 10,
                    font: customFont,
                    rotate: degrees(90),
                })
            }else{
                page1.drawText((this.gaiheki[1].HWpoint).toString(), {
                    x: 177,
                    y: 293,
                    size: 10,
                    font: customFont,
                    rotate: degrees(90),
                })
            }
        }

        if(this.gaiheki[1].LWgrid !== null){
            if((this.gaiheki[1].LWgrid * 0.91).toString().length == 5){
                page1.drawText((this.gaiheki[1].LWgrid * 0.91).toString(), {
                    x: 194,
                    y: 288,
                    size: 10,
                    font: customFont,
                    rotate: degrees(90),
                })
            }else if((this.gaiheki[1].LWgrid * 0.91).toString().length == 1){
                page1.drawText((this.gaiheki[1].LWgrid * 0.91).toString(), {
                    x: 194,
                    y: 308,
                    size: 10,
                    font: customFont,
                    rotate: degrees(90),
                })
            }else{
                page1.drawText((this.gaiheki[1].LWgrid * 0.91).toString(), {
                    x: 194,
                    y: 293,
                    size: 10,
                    font: customFont,
                    rotate: degrees(90),
                })
            }
        }

        if(this.gaiheki[1].LWpoint !== null){
            if((this.gaiheki[1].LWpoint).toString().length == 5){
                page1.drawText((this.gaiheki[1].LWpoint).toString(), {
                    x: 211,
                    y: 288,
                    size: 10,
                    font: customFont,
                    rotate: degrees(90),
                })
            }else if((this.gaiheki[1].LWpoint).toString().length == 1){
                page1.drawText((this.gaiheki[1].LWpoint).toString(), {
                    x: 211,
                    y: 308,
                    size: 10,
                    font: customFont,
                    rotate: degrees(90),
                })
            }else{
                page1.drawText((this.gaiheki[1].LWpoint).toString(), {
                    x: 211,
                    y: 293,
                    size: 10,
                    font: customFont,
                    rotate: degrees(90),
                })
            }
        }

        if(this.gaiheki[1].totalSTC !== null){
            if((this.gaiheki[1].totalSTC).toString().length == 5){
                page1.drawText((this.gaiheki[1].totalSTC).toString(), {
                    x: 227,
                    y: 288,
                    size: 10,
                    font: customFont,
                    rotate: degrees(90),
                })
            }else if((this.gaiheki[1].totalSTC).toString().length == 1){
                page1.drawText((this.gaiheki[1].totalSTC).toString(), {
                    x: 227,
                    y: 308,
                    size: 10,
                    font: customFont,
                    rotate: degrees(90),
                })
            }else{
                page1.drawText((this.gaiheki[1].totalSTC).toString(), {
                    x: 227,
                    y: 293,
                    size: 10,
                    font: customFont,
                    rotate: degrees(90),
                })
            }
        }

        if((this.gaiheki[1].finalPoint).toString().length == 5){
            page1.drawText((this.gaiheki[1].finalPoint).toString(), {
                x: 243,
                y: 288,
                size: 10,
                font: customFont,
                rotate: degrees(90),
            })
        }else if((this.gaiheki[1].finalPoint).toString().length == 1){
            page1.drawText((this.gaiheki[1].finalPoint).toString(), {
                x: 243,
                y: 308,
                size: 10,
                font: customFont,
                rotate: degrees(90),
            })
        }else{
            page1.drawText((this.gaiheki[1].finalPoint).toString(), {
                x: 243,
                y: 299,
                size: 10,
                font: customFont,
                rotate: degrees(90),
            })
        }

        //////////////////////////// west ////////////////////////////

        if(this.gaiheki[2].HWgrid !== null){
            if((this.gaiheki[2].HWgrid * 0.91).toString().length == 5){
                page1.drawText((this.gaiheki[2].HWgrid * 0.91).toString(), {
                    x: 160,
                    y: 437,
                    size: 10,
                    font: customFont,
                    rotate: degrees(90),
                })
            }else if((this.gaiheki[2].HWgrid * 0.91).toString().length == 1){
                page1.drawText((this.gaiheki[2].HWgrid * 0.91).toString(), {
                    x: 160,
                    y: 456,
                    size: 10,
                    font: customFont,
                    rotate: degrees(90),
                })
            }else{
                page1.drawText((this.gaiheki[2].HWgrid * 0.91).toString(), {
                    x: 160,
                    y: 442,
                    size: 10,
                    font: customFont,
                    rotate: degrees(90),
                })
            }
        }

        if(this.gaiheki[2].HWpoint !== null){
            if((this.gaiheki[2].HWpoint).toString().length == 5){
                page1.drawText((this.gaiheki[2].HWpoint).toString(), {
                    x: 177,
                    y: 437,
                    size: 10,
                    font: customFont,
                    rotate: degrees(90),
                })
            }else if((this.gaiheki[2].HWpoint).toString().length == 1){
                page1.drawText((this.gaiheki[2].HWpoint).toString(), {
                    x: 177,
                    y: 456,
                    size: 10,
                    font: customFont,
                    rotate: degrees(90),
                })
            }else{
                page1.drawText((this.gaiheki[2].HWpoint).toString(), {
                    x: 177,
                    y: 442,
                    size: 10,
                    font: customFont,
                    rotate: degrees(90),
                })
            }
        }

        if(this.gaiheki[2].LWgrid !== null){
            if((this.gaiheki[2].LWgrid * 0.91).toString().length == 5){
                page1.drawText((this.gaiheki[2].LWgrid * 0.91).toString(), {
                    x: 194,
                    y: 437,
                    size: 10,
                    font: customFont,
                    rotate: degrees(90),
                })
            }else if((this.gaiheki[2].LWgrid * 0.91).toString().length == 1){
                page1.drawText((this.gaiheki[2].LWgrid * 0.91).toString(), {
                    x: 194,
                    y: 456,
                    size: 10,
                    font: customFont,
                    rotate: degrees(90),
                })
            }else{
                page1.drawText((this.gaiheki[2].LWgrid * 0.91).toString(), {
                    x: 194,
                    y: 442,
                    size: 10,
                    font: customFont,
                    rotate: degrees(90),
                })
            }
        }

        if(this.gaiheki[2].LWpoint !== null){
            if((this.gaiheki[2].LWpoint).toString().length == 5){
                page1.drawText((this.gaiheki[2].LWpoint).toString(), {
                    x: 211,
                    y: 437,
                    size: 10,
                    font: customFont,
                    rotate: degrees(90),
                })
            }else if((this.gaiheki[2].LWpoint).toString().length == 1){
                page1.drawText((this.gaiheki[2].LWpoint).toString(), {
                    x: 211,
                    y: 456,
                    size: 10,
                    font: customFont,
                    rotate: degrees(90),
                })
            }else{
                page1.drawText((this.gaiheki[2].LWpoint).toString(), {
                    x: 211,
                    y: 442,
                    size: 10,
                    font: customFont,
                    rotate: degrees(90),
                })
            }
        }

        if(this.gaiheki[2].totalSTC !== null){
            if((this.gaiheki[2].totalSTC).toString().length == 5){
                page1.drawText((this.gaiheki[2].totalSTC).toString(), {
                    x: 227,
                    y: 437,
                    size: 10,
                    font: customFont,
                    rotate: degrees(90),
                })
            }else if((this.gaiheki[2].totalSTC).toString().length == 1){
                page1.drawText((this.gaiheki[2].totalSTC).toString(), {
                    x: 227,
                    y: 456,
                    size: 10,
                    font: customFont,
                    rotate: degrees(90),
                })
            }else{
                page1.drawText((this.gaiheki[2].totalSTC).toString(), {
                    x: 227,
                    y: 442,
                    size: 10,
                    font: customFont,
                    rotate: degrees(90),
                })
            }
        }

        if((this.gaiheki[2].finalPoint).toString().length == 5){
            page1.drawText((this.gaiheki[2].finalPoint).toString(), {
                x: 243,
                y: 437,
                size: 10,
                font: customFont,
                rotate: degrees(90),
            })
        }else if((this.gaiheki[2].finalPoint).toString().length == 1){
            page1.drawText((this.gaiheki[2].finalPoint).toString(), {
                x: 243,
                y: 456,
                size: 10,
                font: customFont,
                rotate: degrees(90),
            })
        }else{
            page1.drawText((this.gaiheki[2].finalPoint).toString(), {
                x: 243,
                y: 448,
                size: 10,
                font: customFont,
                rotate: degrees(90),
            })
        }

        //////////////////////////// north ////////////////////////////

        if(this.gaiheki[3].HWgrid !== null){
            if((this.gaiheki[3].HWgrid * 0.91).toString().length == 5){
                page1.drawText((this.gaiheki[3].HWgrid * 0.91).toString(), {
                    x: 160,
                    y: 583,
                    size: 10,
                    font: customFont,
                    rotate: degrees(90),
                })
            }else if((this.gaiheki[3].HWgrid * 0.91).toString().length == 1){
                page1.drawText((this.gaiheki[3].HWgrid * 0.91).toString(), {
                    x: 160,
                    y: 603,
                    size: 10,
                    font: customFont,
                    rotate: degrees(90),
                })
            }else{
                page1.drawText((this.gaiheki[3].HWgrid * 0.91).toString(), {
                    x: 160,
                    y: 588,
                    size: 10,
                    font: customFont,
                    rotate: degrees(90),
                })
            }
        }

        if(this.gaiheki[3].HWpoint !== null){
            if((this.gaiheki[3].HWpoint).toString().length == 5){
                page1.drawText((this.gaiheki[3].HWpoint).toString(), {
                    x: 177,
                    y: 583,
                    size: 10,
                    font: customFont,
                    rotate: degrees(90),
                })
            }else if((this.gaiheki[1].HWpoint).toString().length == 1){
                page1.drawText((this.gaiheki[3].HWpoint).toString(), {
                    x: 177,
                    y: 603,
                    size: 10,
                    font: customFont,
                    rotate: degrees(90),
                })
            }else{
                page1.drawText((this.gaiheki[3].HWpoint).toString(), {
                    x: 177,
                    y: 588,
                    size: 10,
                    font: customFont,
                    rotate: degrees(90),
                })
            }
        }

        if(this.gaiheki[3].LWgrid !== null){
            if((this.gaiheki[3].LWgrid * 0.91).toString().length == 5){
                page1.drawText((this.gaiheki[3].LWgrid * 0.91).toString(), {
                    x: 194,
                    y: 583,
                    size: 10,
                    font: customFont,
                    rotate: degrees(90),
                })
            }else if((this.gaiheki[3].LWgrid * 0.91).toString().length == 1){
                page1.drawText((this.gaiheki[3].LWgrid * 0.91).toString(), {
                    x: 194,
                    y: 603,
                    size: 10,
                    font: customFont,
                    rotate: degrees(90),
                })
            }else{
                page1.drawText((this.gaiheki[3].LWgrid * 0.91).toString(), {
                    x: 194,
                    y: 588,
                    size: 10,
                    font: customFont,
                    rotate: degrees(90),
                })
            }
        }

        if(this.gaiheki[3].LWpoint !== null){
            if((this.gaiheki[3].LWpoint).toString().length == 5){
                page1.drawText((this.gaiheki[3].LWpoint).toString(), {
                    x: 211,
                    y: 583,
                    size: 10,
                    font: customFont,
                    rotate: degrees(90),
                })
            }else if((this.gaiheki[3].LWpoint).toString().length == 1){
                page1.drawText((this.gaiheki[3].LWpoint).toString(), {
                    x: 211,
                    y: 603,
                    size: 10,
                    font: customFont,
                    rotate: degrees(90),
                })
            }else{
                page1.drawText((this.gaiheki[3].LWpoint).toString(), {
                    x: 211,
                    y: 588,
                    size: 10,
                    font: customFont,
                    rotate: degrees(90),
                })
            }
        }

        if(this.gaiheki[3].totalSTC !== null){
            if((this.gaiheki[3].totalSTC).toString().length == 5){
                page1.drawText((this.gaiheki[3].totalSTC).toString(), {
                    x: 227,
                    y: 583,
                    size: 10,
                    font: customFont,
                    rotate: degrees(90),
                })
            }else if((this.gaiheki[3].totalSTC).toString().length == 1){
                page1.drawText((this.gaiheki[3].totalSTC).toString(), {
                    x: 227,
                    y: 603,
                    size: 10,
                    font: customFont,
                    rotate: degrees(90),
                })
            }else{
                page1.drawText((this.gaiheki[3].totalSTC).toString(), {
                    x: 227,
                    y: 588,
                    size: 10,
                    font: customFont,
                    rotate: degrees(90),
                })
            }
        }

        if((this.gaiheki[3].finalPoint).toString().length == 5){
            page1.drawText((this.gaiheki[3].finalPoint).toString(), {
                x: 243,
                y: 583,
                size: 10,
                font: customFont,
                rotate: degrees(90),
            })
        }else if((this.gaiheki[3].finalPoint).toString().length == 1){
            page1.drawText((this.gaiheki[3].finalPoint).toString(), {
                x: 243,
                y: 603,
                size: 10,
                font: customFont,
                rotate: degrees(90),
            })
        }else{
            page1.drawText((this.gaiheki[3].finalPoint).toString(), {
                x: 243,
                y: 594,
                size: 10,
                font: customFont,
                rotate: degrees(90),
            })
        }

        ///////////////////////////////////////////////////////////// COLUMNS /////////////////////////////////////////////////////////////

        let textcolumn = 160;
        let boxcolumn = 147.2;

        for (let x = 0; x < this.columnData.length; x++) {
            let item = this.columnData[x];
            
            if(item.columnName == ""){
                continue;
            }else{
                page1.drawRectangle({
                    x: boxcolumn,
                    y: 615.2,
                    width: 16.1,
                    height: 157.09,
                    borderColor: rgb(0, 0, 0),
                    borderWidth: 0.2,
                })
                
                page1.drawRectangle({
                    x: boxcolumn,
                    y: 772.5,
                    width: 16.1,
                    height: 42.7,
                    borderColor: rgb(0, 0, 0),
                    borderWidth: 0.2,
                })
        
                page1.drawText(item.columnName, {
                    x: textcolumn,
                    y: 618,
                    size: 9.5,
                    font: customFont,
                    rotate: degrees(90),
                })
        
                page1.drawText(item.quantity.toString(), {
                    x: textcolumn,
                    y: 792,
                    size: 9.5,
                    font: customFont,
                    rotate: degrees(90),
                })
                
                textcolumn += 16.1;
                boxcolumn += 16.1;
            }
        }

        ///////////////////////////////////////////////////////////// ENTRANCE /////////////////////////////////////////////////////////////

        ///////////////////////////////// east /////////////////////////////////

        let text_eastentrance = 293;
        let box_eastentrance = 282.02;
        let eastdoorname = "";

        for (let x = 0; x < this.doorData.eastDoorData.length; x++) {
            let item = this.doorData.eastDoorData[x];
            
            if(item.doorType == "0"){
                continue;
            }else{
                if(item.doorType == "1.54"){
                    eastdoorname = "Door 3.0"
                }else if(item.doorType == "2.64"){
                    eastdoorname = "Door 4.5"
                }else if(item.doorType == "3.74"){
                    eastdoorname = "Door 6.0"
                }else if(item.doorType == "5.28"){
                    eastdoorname = "Door 9.0"
                }

                page1.drawRectangle({
                    x: box_eastentrance,
                    y: 25.3,
                    width: 16.1,
                    height: 71.8,
                    borderColor: rgb(0, 0, 0),
                    borderWidth: 0.2,
                })
        
                page1.drawRectangle({
                    x: box_eastentrance,
                    y: 97,
                    width: 16.1,
                    height: 72,
                    borderColor: rgb(0, 0, 0),
                    borderWidth: 0.2,
                })
        
                page1.drawText(eastdoorname, {
                    x: text_eastentrance,
                    y: 43,
                    size: 9.5,
                    font: customFont,
                    rotate: degrees(90),
                })
        
                page1.drawText(item.doorQty.toString(), {
                    x: text_eastentrance,
                    y: 131,
                    size: 9.5,
                    font: customFont,
                    rotate: degrees(90),
                })
                
                text_eastentrance += 16.1;
                box_eastentrance += 16.1;
            }
        }

        //////////////////////////////// south /////////////////////////////////

        let text_southentrance = 293;
        let box_southentrance = 282.02;
        let southdoorname = "";

        for (let x = 0; x < this.doorData.southDoorData.length; x++) {
            let item = this.doorData.southDoorData[x];
            
            if(item.doorType == "0"){
                continue;
            }else{
                if(item.doorType == "1.54"){
                    southdoorname = "Door 3.0"
                }else if(item.doorType == "2.64"){
                    southdoorname = "Door 4.5"
                }else if(item.doorType == "3.74"){
                    southdoorname = "Door 6.0"
                }else if(item.doorType == "5.28"){
                    southdoorname = "Door 9.0"
                }

                page1.drawRectangle({
                    x: box_southentrance,
                    y: 172.35,
                    width: 16.1,
                    height: 72,
                    borderColor: rgb(0, 0, 0),
                    borderWidth: 0.2,
                })
        
                page1.drawRectangle({
                    x: box_southentrance,
                    y: 244.5,
                    width: 16.1,
                    height: 71.9,
                    borderColor: rgb(0, 0, 0),
                    borderWidth: 0.2,
                })
        
                page1.drawText(southdoorname, {
                    x: text_southentrance,
                    y: 190,
                    size: 9.5,
                    font: customFont,
                    rotate: degrees(90),
                })
        
                page1.drawText(item.doorQty.toString(), {
                    x: text_southentrance,
                    y: 279,
                    size: 9.5,
                    font: customFont,
                    rotate: degrees(90),
                })
                
                text_southentrance += 16.1;
                box_southentrance += 16.1;
            }
        }

        //////////////////////////////// west /////////////////////////////////

        let text_westentrance = 293;
        let box_westentrance = 282.02;
        let westdoorname = "";

        for (let x = 0; x < this.doorData.westDoorData.length; x++) {
            let item = this.doorData.westDoorData[x];
            
            if(item.doorType == "0"){
                continue;
            }else{
                if(item.doorType == "1.54"){
                    westdoorname = "Door 3.0"
                }else if(item.doorType == "2.64"){
                    westdoorname = "Door 4.5"
                }else if(item.doorType == "3.74"){
                    westdoorname = "Door 6.0"
                }else if(item.doorType == "5.28"){
                    westdoorname = "Door 9.0"
                }

                page1.drawRectangle({
                    x: box_westentrance,
                    y: 319.8,
                    width: 16.1,
                    height: 72.1,
                    borderColor: rgb(0, 0, 0),
                    borderWidth: 0.2,
                })
        
                page1.drawRectangle({
                    x: box_westentrance,
                    y: 392,
                    width: 16.1,
                    height: 72.2,
                    borderColor: rgb(0, 0, 0),
                    borderWidth: 0.2,
                })
        
                page1.drawText(westdoorname, {
                    x: text_westentrance,
                    y: 338,
                    size: 9.5,
                    font: customFont,
                    rotate: degrees(90),
                })
        
                page1.drawText(item.doorQty.toString(), {
                    x: text_westentrance,
                    y: 426,
                    size: 9.5,
                    font: customFont,
                    rotate: degrees(90),
                })
                
                text_westentrance += 16.1;
                box_westentrance += 16.1;
            }
        }

        //////////////////////////////// north /////////////////////////////////

        let text_northentrance = 293;
        let box_northentrance = 282.02;
        let northdoorname = "";

        for (let x = 0; x < this.doorData.northDoorData.length; x++) {
            let item = this.doorData.northDoorData[x];
            
            if(item.doorType == "0"){
                continue;
            }else{
                if(item.doorType == "1.54"){
                    northdoorname = "Door 3.0"
                }else if(item.doorType == "2.64"){
                    northdoorname = "Door 4.5"
                }else if(item.doorType == "3.74"){
                    northdoorname = "Door 6.0"
                }else if(item.doorType == "5.28"){
                    northdoorname = "Door 9.0"
                }

                page1.drawRectangle({
                    x: box_northentrance,
                    y: 467.8,
                    width: 16.1,
                    height: 71.8,
                    borderColor: rgb(0, 0, 0),
                    borderWidth: 0.2,
                })
        
                page1.drawRectangle({
                    x: box_northentrance,
                    y: 539.8,
                    width: 16.1,
                    height: 71.9,
                    borderColor: rgb(0, 0, 0),
                    borderWidth: 0.2,
                })
        
                page1.drawText(northdoorname, {
                    x: text_northentrance,
                    y: 485,
                    size: 9.5,
                    font: customFont,
                    rotate: degrees(90),
                })
        
                page1.drawText(item.doorQty.toString(), {
                    x: text_northentrance,
                    y: 574,
                    size: 9.5,
                    font: customFont,
                    rotate: degrees(90),
                })
                
                text_northentrance += 16.1;
                box_northentrance += 16.1;
            }
        }

        ///////////////////////////////////////////////////////////// BALCONY /////////////////////////////////////////////////////////////

        let textbalcony = 294;
        let boxbalcony = 282.02;

        for (let x = 0; x < this.balconyData.length; x++) {
            let item = this.balconyData[x];
            
            if(item.type == ""){
                continue;
            }else{
                page1.drawRectangle({
                    x: boxbalcony,
                    y: 615.15,
                    width: 16.1,
                    height: 71.9,
                    borderColor: rgb(0, 0, 0),
                    borderWidth: 0.2,
                })
        
                page1.drawRectangle({
                    x: boxbalcony,
                    y: 687,
                    width: 16.1,
                    height: 42.8,
                    borderColor: rgb(0, 0, 0),
                    borderWidth: 0.2,
                })
        
                page1.drawRectangle({
                    x: boxbalcony,
                    y: 729.8,
                    width: 16.1,
                    height: 42.6,
                    borderColor: rgb(0, 0, 0),
                    borderWidth: 0.2,
                })
        
                page1.drawRectangle({
                    x: boxbalcony,
                    y: 772.5,
                    width: 16.1,
                    height: 42.7,
                    borderColor: rgb(0, 0, 0),
                    borderWidth: 0.2,
                })
        
                if(item.tempService == 0){
                    page1.drawText(item.tempOption.toString(), {
                        x: textbalcony,
                        y: 642,
                        size: 9.5,
                        font: customFont,
                        rotate: degrees(90),
                    })
                }else if(item.tempOption == 0){
                    page1.drawText(item.tempService.toString(), {
                        x: textbalcony,
                        y: 642,
                        size: 9.5,
                        font: customFont,
                        rotate: degrees(90),
                    })
                }
        
                page1.drawText(item.left.toString(), {
                    x: textbalcony,
                    y: 707,
                    size: 9.5,
                    font: customFont,
                    rotate: degrees(90),
                })
        
                page1.drawText(item.center.toString(), {
                    x: textbalcony,
                    y: 749,
                    size: 9.5,
                    font: customFont,
                    rotate: degrees(90),
                })
        
                page1.drawText(item.right.toString(), {
                    x: textbalcony,
                    y: 792,
                    size: 9.5,
                    font: customFont,
                    rotate: degrees(90),
                })
                
                textbalcony += 16.1;
                boxbalcony += 16.1;
            }
        }
        

        ///////////////////////////////////////////////////////////// SASHES /////////////////////////////////////////////////////////////

        ///////////////////////////////// east /////////////////////////////////

        let text_eastsash = 425;
        let box_eastsash = 413.4;
        let amado_east = 0;

        for (let x = 0; x < this.sashData.eastSashData.length; x++) {
            let item = this.sashData.eastSashData[x];
            
            if(item.sashPoint == 0 || item.sashPoint == null){
                continue;
            }else{
                if(item.withAmado == "No"){
                    amado_east = 110
                }else{
                    amado_east = 107
                }

                page1.drawRectangle({
                    x: box_eastsash,
                    y: 25.4,
                    width: 16.1,
                    height: 35.9,
                    borderColor: rgb(0, 0, 0),
                    borderWidth: 0.2,
                })
        
                page1.drawRectangle({
                    x: box_eastsash,
                    y: 61.2,
                    width: 16.1,
                    height: 35.9,
                    borderColor: rgb(0, 0, 0),
                    borderWidth: 0.2,
                })
        
                page1.drawRectangle({
                    x: box_eastsash,
                    y: 97.1,
                    width: 16.1,
                    height: 35.9,
                    borderColor: rgb(0, 0, 0),
                    borderWidth: 0.2,
                })
        
                page1.drawRectangle({
                    x: box_eastsash,
                    y: 133,
                    width: 16.1,
                    height: 36,
                    borderColor: rgb(0, 0, 0),
                    borderWidth: 0.2,
                })
        
                page1.drawText(item.width.toString(), {
                    x: text_eastsash,
                    y: 38,
                    size: 9.5,
                    font: customFont,
                    rotate: degrees(90),
                })
        
                page1.drawText(item.height.toString(), {
                    x: text_eastsash,
                    y: 74,
                    size: 9.5,
                    font: customFont,
                    rotate: degrees(90),
                })
        
                page1.drawText(item.withAmado, {
                    x: text_eastsash,
                    y: amado_east,
                    size: 9.5,
                    font: customFont,
                    rotate: degrees(90),
                })
        
                page1.drawText(item.inclusion, {
                    x: text_eastsash,
                    y: 142,
                    size: 9.5,
                    font: customFont,
                    rotate: degrees(90),
                })
                
                text_eastsash += 16.1;
                box_eastsash += 16.1;
            }
        }

        ///////////////////////////////// south /////////////////////////////////

        let text_southsash = 425;
        let box_southsash = 413.4;
        let amado_south = 0;

        for (let x = 0; x < this.sashData.southSashData.length; x++) {
            let item = this.sashData.southSashData[x];
            
            if(item.sashPoint == 0 || item.sashPoint == null){
                continue;
            }else{
                if(item.withAmado == "No"){
                    amado_south = 257.4
                }else{
                    amado_south = 254.4
                }

                page1.drawRectangle({
                    x: box_southsash,
                    y: 172.5,
                    width: 16.1,
                    height: 35.9,
                    borderColor: rgb(0, 0, 0),
                    borderWidth: 0.2,
                })
        
                page1.drawRectangle({
                    x: box_southsash,
                    y: 208.4,
                    width: 16.1,
                    height: 35.9,
                    borderColor: rgb(0, 0, 0),
                    borderWidth: 0.2,
                })
        
                page1.drawRectangle({
                    x: box_southsash,
                    y: 244.5,
                    width: 16.1,
                    height: 35.9,
                    borderColor: rgb(0, 0, 0),
                    borderWidth: 0.2,
                })
        
                page1.drawRectangle({
                    x: box_southsash,
                    y: 280.5,
                    width: 16.1,
                    height: 36,
                    borderColor: rgb(0, 0, 0),
                    borderWidth: 0.2,
                })
        
                page1.drawText(item.width.toString(), {
                    x: text_southsash,
                    y: 185.1,
                    size: 9.5,
                    font: customFont,
                    rotate: degrees(90),
                })
        
                page1.drawText(item.height.toString(), {
                    x: text_southsash,
                    y: 221.2,
                    size: 9.5,
                    font: customFont,
                    rotate: degrees(90),
                })
        
                page1.drawText(item.withAmado, {
                    x: text_southsash,
                    y: amado_south,
                    size: 9.5,
                    font: customFont,
                    rotate: degrees(90),
                })
        
                page1.drawText(item.inclusion, {
                    x: text_southsash,
                    y: 289.5,
                    size: 9.5,
                    font: customFont,
                    rotate: degrees(90),
                })
                
                text_southsash += 16.1;
                box_southsash += 16.1;
            }
        }

        ///////////////////////////////// west /////////////////////////////////

        let text_westsash = 425;
        let box_westsash = 413.4;
        let amado_west = 0;

        for (let x = 0; x < this.sashData.westSashData.length; x++) {
            let item = this.sashData.westSashData[x];
            
            if(item.sashPoint == 0 || item.sashPoint == null){
                continue;
            }else{
                if(item.withAmado == "No"){
                    amado_west = 404.9
                }else{
                    amado_west = 401.9
                }

                page1.drawRectangle({
                    x: box_westsash,
                    y: 319.8,
                    width: 16.1,
                    height: 36.1,
                    borderColor: rgb(0, 0, 0),
                    borderWidth: 0.2,
                })
        
                page1.drawRectangle({
                    x: box_westsash,
                    y: 356,
                    width: 16.1,
                    height: 35.9,
                    borderColor: rgb(0, 0, 0),
                    borderWidth: 0.2,
                })
        
                page1.drawRectangle({
                    x: box_westsash,
                    y: 392,
                    width: 16.1,
                    height: 36.2,
                    borderColor: rgb(0, 0, 0),
                    borderWidth: 0.2,
                })
        
                page1.drawRectangle({
                    x: box_westsash,
                    y: 428.3,
                    width: 16.1,
                    height: 36,
                    borderColor: rgb(0, 0, 0),
                    borderWidth: 0.2,
                })
        
                page1.drawText(item.width.toString(), {
                    x: text_westsash,
                    y: 332.4,
                    size: 9.5,
                    font: customFont,
                    rotate: degrees(90),
                })
        
                page1.drawText(item.height.toString(), {
                    x: text_westsash,
                    y: 368.8,
                    size: 9.5,
                    font: customFont,
                    rotate: degrees(90),
                })
        
                page1.drawText(item.withAmado, {
                    x: text_westsash,
                    y: amado_west,
                    size: 9.5,
                    font: customFont,
                    rotate: degrees(90),
                })
        
                page1.drawText(item.inclusion, {
                    x: text_westsash,
                    y: 437.3,
                    size: 9.5,
                    font: customFont,
                    rotate: degrees(90),
                })
                
                text_westsash += 16.1;
                box_westsash += 16.1;
            }
        }

        ///////////////////////////////// north /////////////////////////////////

        let text_northsash = 425;
        let box_northsash = 413.4;
        let amado_north = 0;

        for (let x = 0; x < this.sashData.northSashData.length; x++) {
            let item = this.sashData.northSashData[x];
            
            if(item.sashPoint == 0 || item.sashPoint == null){
                continue;
            }else{
                if(item.withAmado == "No"){
                    amado_north = 552.6
                }else{
                    amado_north = 549.6
                }

                page1.drawRectangle({
                    x: box_northsash,
                    y: 467.8,
                    width: 16.1,
                    height: 35.9,
                    borderColor: rgb(0, 0, 0),
                    borderWidth: 0.2,
                })
        
                page1.drawRectangle({
                    x: box_northsash,
                    y: 503.8,
                    width: 16.1,
                    height: 35.9,
                    borderColor: rgb(0, 0, 0),
                    borderWidth: 0.2,
                })
        
                page1.drawRectangle({
                    x: box_northsash,
                    y: 539.7,
                    width: 16.1,
                    height: 35.9,
                    borderColor: rgb(0, 0, 0),
                    borderWidth: 0.2,
                })
        
                page1.drawRectangle({
                    x: box_northsash,
                    y: 575.7,
                    width: 16.1,
                    height: 36,
                    borderColor: rgb(0, 0, 0),
                    borderWidth: 0.2,
                })
        
                page1.drawText(item.width.toString(), {
                    x: text_northsash,
                    y: 480.4,
                    size: 9.5,
                    font: customFont,
                    rotate: degrees(90),
                })
        
                page1.drawText(item.height.toString(), {
                    x: text_northsash,
                    y: 516.6,
                    size: 9.5,
                    font: customFont,
                    rotate: degrees(90),
                })
        
                page1.drawText(item.withAmado, {
                    x: text_northsash,
                    y: amado_north,
                    size: 9.5,
                    font: customFont,
                    rotate: degrees(90),
                })
        
                page1.drawText(item.inclusion, {
                    x: text_northsash,
                    y: 584.7,
                    size: 9.5,
                    font: customFont,
                    rotate: degrees(90),
                })
                
                text_northsash += 16.1;
                box_northsash += 16.1;
            }
        }

        ///////////////////////////////////////////////////////////// UNIT DEMADO /////////////////////////////////////////////////////////////

        let textdemado= 425;
        let boxdemado = 413.4;

        for (let x = 0; x < this.demadoData.length; x++) {
            let item = this.demadoData[x];
            
            if(item.kinds == ""){
                continue;
            }else{
                page1.drawRectangle({
                    x: boxdemado,
                    y: 615.2,
                    width: 16.1,
                    height: 157.09,
                    borderColor: rgb(0, 0, 0),
                    borderWidth: 0.2,
                })
        
                page1.drawRectangle({
                    x: boxdemado,
                    y: 772.5,
                    width: 16.1,
                    height: 42.7,
                    borderColor: rgb(0, 0, 0),
                    borderWidth: 0.2,
                })
        
                page1.drawText(item.kinds, {
                    x: textdemado,
                    y: 618,
                    size: 9.5,
                    font: customFont,
                    rotate: degrees(90),
                })
        
                page1.drawText(item.quantity.toString(), {
                    x: textdemado,
                    y: 792,
                    size: 9.5,
                    font: customFont,
                    rotate: degrees(90),
                })
                
                textdemado += 16.1;
                boxdemado += 16.1;
            }
        }


        /////////////////////////////////////////////////// PAGE 2 ///////////////////////////////////////////////////

        //////////////////////////// basic info ////////////////////////////

        page2.drawText(this.data.customerName, {
            x: 61,
            y: 200,
            size: 15,
            font: customFont,
            rotate: degrees(90),
        })

        page2.drawText(this.data.contractDate, {
            x: 90,
            y: 200,
            size: 15,
            font: customFont,
            rotate: degrees(90),
        })

        page2.drawText(this.data.houseType, {
            x: 118,
            y: 200,
            size: 15,
            font: customFont,
            rotate: degrees(90),
        })
        
        page2.drawText(this.today, {
            x: 38,
            y: 730,
            size: 10,
            font: customFont,
            rotate: degrees(90),
        })

        page2.drawText(this.data.customerCode, {
            x: 61,
            y: 670,
            size: 15,
            font: customFont,
            rotate: degrees(90),
        })

        page2.drawText(this.data.planNo, {
            x: 90,
            y: 708,
            size: 15,
            font: customFont,
            rotate: degrees(90),
        })
        
        page2.drawText(this.data.yumeno, {
            x: 118,
            y: 708,
            size: 15,
            font: customFont,
            rotate: degrees(90),
        })

        //////////////////////////// TC ////////////////////////////

        // tile kind
        page2.drawText(this.tileKind, {
            x: 238,
            y: 73,
            size: 20,
            font: customFont,
            rotate: degrees(90),
        })

        // total service
        if(this.totalTile.toFixed(2).toString().length == 6){
            page2.drawText(this.totalTile.toFixed(2).toString(), {
                x: 238,
                y: 150,
                size: 20,
                font: customFont,
                rotate: degrees(90),
            })
        }else if(this.totalTile.toFixed(2).toString().length == 5){
            page2.drawText(this.totalTile.toFixed(2).toString(), {
                x: 238,
                y: 154,
                size: 20,
                font: customFont,
                rotate: degrees(90),
            })
        }else if(this.totalTile.toFixed(2).toString().length == 4){
            page2.drawText(this.totalTile.toFixed(2).toString(), {
                x: 238,
                y: 157,
                size: 20,
                font: customFont,
                rotate: degrees(90),
            })
        }

        // total option
        if(this.option.toFixed(2).toString().length == 6){
            page2.drawText(this.option.toFixed(2).toString(), {
                x: 238,
                y: 280,
                size: 20,
                font: customFont,
                rotate: degrees(90),
            })
        }else if(this.option.toFixed(2).toString().length == 5){
            page2.drawText(this.option.toFixed(2).toString(), {
                x: 238,
                y: 285,
                size: 20,
                font: customFont,
                rotate: degrees(90),
            })
        }else if(this.option.toFixed(2).toString().length == 4){
            page2.drawText(this.option.toFixed(2).toString(), {
                x: 238,
                y: 285,
                size: 20,
                font: customFont,
                rotate: degrees(90),
            })
        }
        
        // total service
        if(this.service.toFixed(2).toString().length == 6){
            page2.drawText(this.service.toFixed(2).toString(), {
                x: 238,
                y: 405,
                size: 20,
                font: customFont,
                rotate: degrees(90),
            })
        }else if(this.service.toFixed(2).toString().length == 5){
            page2.drawText(this.service.toFixed(2).toString(), {
                x: 238,
                y: 410,
                size: 20,
                font: customFont,
                rotate: degrees(90),
            })
        }else if(this.service.toFixed(2).toString().length == 4){
            page2.drawText(this.service.toFixed(2).toString(), {
                x: 238,
                y: 413,
                size: 20,
                font: customFont,
                rotate: degrees(90),
            })
        }

        //demado service
        if(this.demado.servicePoints == 0){
            page2.drawText('-', {
                x: 237,
                y: 530,
                size: 20,
                font: customFont,
                rotate: degrees(90),
            })
        }else if(this.demado.servicePoints.toFixed(2).toString().length == 5){
            page2.drawText(this.demado.servicePoints.toFixed(2).toString(), {
                x: 236,
                y: 512,
                size: 17,
                font: customFont,
                rotate: degrees(90),
            })
        }else if(this.demado.servicePoints.toFixed(2).toString().length == 4){
            page2.drawText(this.demado.servicePoints.toFixed(2).toString(), {
                x: 236,
                y: 518,
                size: 17,
                font: customFont,
                rotate: degrees(90),
            })
        }

        //demado option
        if(this.demado.optionPoints == 0){
            page2.drawText('-', {
                x: 325,
                y: 530,
                size: 20,
                font: customFont,
                rotate: degrees(90),
            })
        }else if(this.demado.optionPoints.toFixed(2).toString().length == 5){
            page2.drawText(this.demado.optionPoints.toFixed(2).toString(), {
                x: 323,
                y: 513,
                size: 17,
                font: customFont,
                rotate: degrees(90),
            })
        }else if(this.demado.optionPoints.toFixed(2).toString().length == 4){
            page2.drawText(this.demado.optionPoints.toFixed(2).toString(), {
                x: 323,
                y: 518,
                size: 17,
                font: customFont,
                rotate: degrees(90),
            })
        }

        //balcony service
        if(this.balcony.servicePoints == 0){
            page2.drawText('-', {
                x: 237,
                y: 593,
                size: 20,
                font: customFont,
                rotate: degrees(90),
            })
        }else if(this.balcony.servicePoints.toFixed(2).toString().length == 5){
            page2.drawText(this.balcony.servicePoints.toFixed(2).toString(), {
                x: 236,
                y: 574,
                size: 17,
                font: customFont,
                rotate: degrees(90),
            })
        }else if(this.balcony.servicePoints.toFixed(2).toString().length == 4){
            page2.drawText(this.balcony.servicePoints.toFixed(2).toString(), {
                x: 236,
                y: 580,
                size: 17,
                font: customFont,
                rotate: degrees(90),
            })
        }

        //balcony option
        if(this.balcony.optionPoints == 0){
            page2.drawText('-', {
                x: 325,
                y: 593,
                size: 20,
                font: customFont,
                rotate: degrees(90),
            })
        }else if(this.balcony.optionPoints.toFixed(2).toString().length == 5){
            page2.drawText(this.balcony.optionPoints.toFixed(2).toString(), {
                x: 323,
                y: 575,
                size: 17,
                font: customFont,
                rotate: degrees(90),
            })
        }else if(this.balcony.optionPoints.toFixed(2).toString().length == 4){
            page2.drawText(this.balcony.optionPoints.toFixed(2).toString(), {
                x: 323,
                y: 582,
                size: 17,
                font: customFont,
                rotate: degrees(90),
            })
        }

        //column service
        if(this.columnPoints.servicePoints == 0){
            page2.drawText('-', {
                x: 237,
                y: 655,
                size: 20,
                font: customFont,
                rotate: degrees(90),
            })
        }else if(this.columnPoints.servicePoints.toFixed(2).toString().length == 5){
            page2.drawText(this.columnPoints.servicePoints.toFixed(2).toString(), {
                x: 236,
                y: 636,
                size: 17,
                font: customFont,
                rotate: degrees(90),
            })
        }else if(this.columnPoints.servicePoints.toFixed(2).toString().length == 4){
            page2.drawText(this.columnPoints.servicePoints.toFixed(2).toString(), {
                x: 236,
                y: 641,
                size: 17,
                font: customFont,
                rotate: degrees(90),
            })
        }

        //column option
        if(this.columnPoints.optionPoints == 0){
            page2.drawText('-', {
                x: 325,
                y: 655,
                size: 20,
                font: customFont,
                rotate: degrees(90),
            })
        }else if(this.columnPoints.optionPoints.toFixed(2).toString().length == 5){
            page2.drawText(this.columnPoints.optionPoints.toFixed(2).toString(), {
                x: 323,
                y: 636,
                size: 17,
                font: customFont,
                rotate: degrees(90),
            })
        }else if(this.columnPoints.optionPoints.toFixed(2).toString().length == 4){
            page2.drawText(this.columnPoints.optionPoints.toFixed(2).toString(), {
                x: 323,
                y: 641,
                size: 17,
                font: customFont,
                rotate: degrees(90),
            })
        }

        // F2 and V3
        page2.drawText('-', {
            x: 237,
            y: 717,
            size: 20,
            font: customFont,
            rotate: degrees(90),
        })

        page2.drawText('-', {
            x: 237,
            y: 770,
            size: 20,
            font: customFont,
            rotate: degrees(90),
        })

        const pdfBytes = await pdfDoc.save();
        return pdfBytes
    }
}