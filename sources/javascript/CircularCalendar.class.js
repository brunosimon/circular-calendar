'use strict';

class CircularCalendar
{
    constructor( options )
    {
        this.options    = options;
        this.circles    = this.options.circles;

        this.setCanvas();

        this.ratio = this.canvas.width / 800;

        this.draw();
    }

    setCanvas()
    {
        this.canvas                = {};
        this.canvas.width          = this.options.width;
        this.canvas.height         = this.options.height;
        this.canvas.element        = this.options.canvas;
        this.canvas.context        = this.canvas.element.getContext( '2d' );
        this.canvas.element.width  = this.canvas.width;
        this.canvas.element.height = this.canvas.height;
        this.canvas.middle         = {};
        this.canvas.middle.x       = Math.round( this.canvas.width * 0.5 );
        this.canvas.middle.y       = Math.round( this.canvas.height * 0.5 );
    }

    draw()
    {
        this.drawBackground();
        this.drawMonths();
        this.drawCircles();
        // this.drawTitles();
        this.drawLegends();
    }

    drawBackground()
    {
        this.canvas.context.fillStyle = this.options.background;
        this.canvas.context.fillRect( 0, 0, this.canvas.width, this.canvas.height );
    }

    drawCircles()
    {
        let sector_angle_length = ( this.options.circumferences.end - this.options.circumferences.start ) / this.options.sectors,
            radius_min          = ( this.options.diameters.inner * this.canvas.width * 0.5 ),
            radius_amplitude    = ( this.options.diameters.outer * this.canvas.width * 0.5 ) - radius_min,
            thickness           = this.canvas.width * 0.5 * this.options.thickness;

        this.canvas.context.lineWidth = thickness;
        this.canvas.context.lineCap   = 'butt';

        // Each sector
        for( let _sector_index = 0; _sector_index < this.options.sectors; _sector_index++ )
        {
            let sector_angle_start = this.options.circumferences.start + sector_angle_length * _sector_index,
                sector_angle_end   = sector_angle_start + sector_angle_length;

            // Each circle
            for( let _circle_index in this.circles )
            {
                let circle = this.circles[ _circle_index ],
                    radius = radius_min + radius_amplitude * ( _circle_index / this.circles.length ),
                    value  = circle.values[ _sector_index ];

                this.canvas.context.strokeStyle = circle.style;

                if( value )
                {
                    this.canvas.context.beginPath();
                    this.canvas.context.arc(
                        this.canvas.middle.x,
                        this.canvas.middle.y,
                        radius,
                        sector_angle_start,
                        sector_angle_end + 0.001
                    );
                    this.canvas.context.stroke();
                }
            }
        }
    }

    drawTitles()
    {
        this.canvas.context.textAlign    = 'center';
        this.canvas.context.textBaseline = 'alphabetic';
        this.canvas.context.font         = 'bold 100px Helvetica';
        this.canvas.context.fillStyle    = '#eee';
        this.canvas.context.fillText( 'LOREM IPSUM', this.canvas.middle.x, 160 );

        this.canvas.context.font = '40px Helvetica';
        this.canvas.context.fillText( 'DOLORES', this.canvas.middle.x, 220 );
    }

    drawLegends()
    {
        let radius_min       = ( this.options.diameters.inner * this.canvas.width * 0.5 ),
            radius_amplitude = ( this.options.diameters.outer * this.canvas.width * 0.5 ) - radius_min,
            text_size        = this.ratio * 6;

        // Each circle
        for( let _circle_index in this.circles )
        {
            let circle = this.circles[ _circle_index ],
                radius = radius_min + radius_amplitude * ( _circle_index / this.circles.length );

            // Style
            this.canvas.context.textAlign    = 'right';
            this.canvas.context.textBaseline = 'middle';
            this.canvas.context.font         = 'lighter ' + text_size + 'px Helvetica';
            this.canvas.context.fillStyle    = circle.style;

            this.canvas.context.fillText( circle.name.toUpperCase(), this.canvas.middle.x - 4, this.canvas.middle.y - radius );
        }
    }

    drawMonths()
    {
        let sector_angle_length = ( this.options.circumferences.end - this.options.circumferences.start ) / this.options.sectors,
            months_names        = [ 'JANUARY','FEBRUARY','MARCH','APRIL','MAY','JUNE','JULY','AUGUST','SEPTEMBER','OCTOBER','NOVEMBER','DECEMBER' ],
            months_durations    = [ 31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31 ],
            radius_min          = ( this.options.diameters.inner * this.canvas.width * 0.5 ),
            radius_max          = ( this.options.diameters.outer * this.canvas.width * 0.5 );

        // Style
        var gradient = this.canvas.context.createRadialGradient(
            this.canvas.middle.x,
            this.canvas.middle.y,
            radius_min * 0.75,
            this.canvas.middle.x,
            this.canvas.middle.y,
            radius_max
        );
        gradient.addColorStop( 0, 'rgba(255,255,255,0)' );
        gradient.addColorStop( 0.15, 'rgba(255,255,255,1)' );
        gradient.addColorStop( 1, 'rgba(255,255,255,0)' );

        this.canvas.context.lineWidth   = Math.round( this.canvas.width * 0.0005 );
        this.canvas.context.strokeStyle = gradient;

        // Each month
        let line_angle = this.options.circumferences.start;
        for( let i = 0; i < 12; i++ )
        {
            let month_duration     = months_durations[ i ],
                month_angle_length = month_duration * sector_angle_length;

            // Line
            line_angle += month_angle_length;

            if( i < 11 )
            {
                this.canvas.context.beginPath();
                this.canvas.context.moveTo(
                    this.canvas.middle.x,
                    this.canvas.middle.y
                );
                this.canvas.context.lineTo(
                    this.canvas.middle.x + Math.cos( line_angle ) * radius_max,
                    this.canvas.middle.y + Math.sin( line_angle ) * radius_max
                );
                this.canvas.context.stroke();
            }

            // Text
            let month_name  = months_names[ i ],
                month_angle = line_angle - month_angle_length * 0.5,
                text_size   = this.ratio * 4;

            this.canvas.context.textAlign    = 'center';
            this.canvas.context.textBaseline = 'middle';
            this.canvas.context.font         = 'lighter ' + text_size + 'px Helvetica';
            this.canvas.context.fillStyle    = '#ccc';
            this.canvas.context.translate( this.canvas.middle.x, this.canvas.middle.y );
            this.canvas.context.rotate( ( month_angle + Math.PI * 0.5 ) );
            this.canvas.context.translate( 0, - radius_min * 0.875 );

            this.canvas.context.fillText(
                month_name,
                0,
                0
            );
            this.canvas.context.translate( 0, radius_min * 0.875 );
            this.canvas.context.rotate( - ( month_angle + Math.PI * 0.5 ) );
            this.canvas.context.translate( - this.canvas.middle.x, - this.canvas.middle.y );
        }
    }
}
