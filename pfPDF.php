<?php

namespace PortalFlare\ReportBundle;

use TCPDF;

class pfPDF extends \TCPDF {
  protected $headertext1;
  protected $headertext2;
  protected $headertext3;
  protected $headertext4;
  protected $headeralign = 'C'; // L, C, R
  protected $columns = array();
  protected $columnheadertextcolor = array('r' => 0, 'g' => 0, 'b' => 0);
  protected $columnheaderfillcolor = array('r' => 192, 'g' => 192, 'b' => 192);
  protected $columnheaderbordercolor = array('r' => 0, 'g' => 0, 'b' => 0);
  protected $ewhere;
  protected $logofile;


  public function setLogoFile($file) {
    $this->logofile = $file;
  }

  public function setColumnRows($rows) {
    $this->columnrows = $rows;
  }

  public function getColumnRows() {
    return $this->columnrows;
  }

  public function setColumns($columns) {
    $this->columns = $columns;
  }

  public function getColumns() {
    return $this->columns;
  }

  public function setEwhere($ewhere) {
    $this->ewhere = $ewhere;
  }

  public function setHeaderalign($align) {
    $this->headeralign = $align;
  }

  public function setHeaderText1($headertext1) {
    $this->headertext1 = $headertext1;
  }

  public function setHeaderText2($headertext2) {
    $this->headertext2 = $headertext2;
  }

  public function setHeaderText3($headertext3) {
    $this->headertext3 = $headertext3;
  }

  public function setHeaderText4($headertext4) {
    $this->headertext4 = $headertext4;
  }

  //Page header
  public function Header() {
    if ($this->print_header) {
      $this->SetFont('helvetica', 'B', 14);
      //$this->SetXY(0, 18);
      $this->Cell(0, 0, $this->headertext1, 0, false, $this->headeralign, 0, '', 0, false, 'M', 'M');
      $this->Ln();
      $this->SetFont('helvetica', '', 12);
      $this->Cell(0, 0, $this->headertext2, 0, false, $this->headeralign, 0, '', 0, false, 'M', 'M');
      $this->Ln();
      $this->Cell(0, 0, $this->headertext3, 0, false, $this->headeralign, 0, '', 0, false, 'M', 'M');
      $this->Ln();
      $this->Cell(0, 0, $this->headertext4, 0, false, $this->headeralign, 0, '', 0, false, 'M', 'M');
      $this->Ln(12);
      $this->SetFont('dejavusans', '', 8, '', true);
      $this->MultiCell(0, 0, $this->ewhere, 0, 'C', false, 0, '', '', true, 0, false, true, 0, 'T', false);
      if (sizeof($this->columns) > 0) {
        $this->Ln();
        $this->SetFont('dejavusans', 'B', 8, '', true);
        $this->SetFillColor($this->columnheaderfillcolor['r'], $this->columnheaderfillcolor['g'], $this->columnheaderfillcolor['b']);
        // Get row height
        $rowheight = 0;
        foreach ($this->getColumns() as $column) {
          $cellheight = $this->getStringHeight(0, $column['label'], false, true, '', 1);
          if ($cellheight > $rowheight) {
            $rowheight = $cellheight;
          }
        }
        // Output row
        foreach ($this->columns as $column) {
          $this->MultiCell($column['width'], $rowheight, $column['label'], 1, $column['align'], true, 0, '', '', true, 0, false, true, $rowheight, 'B', false);
        }
      }
      $this->Ln();
      $this->SetTopMargin($this->GetY());

      if ($this->logofile) {
        $image_file = $_SERVER['DOCUMENT_ROOT'] . $this->logofile;
        $this->Image($image_file, 18, 18, 108, 0, '', '', 'T', false, 300, '', false, false, 0, false, false, false);
      }

    }
  }

  // Page footer
  public function Footer() {
    if ($this->print_footer) {
      $this->SetY(-36);
      //$this->Line($this->getX(), $this->getY(), $this->getX() + 756, $this->getY());
      $this->SetFont('helvetica', 'I', 10);
      // DateTime
      $this->Cell(144, 0, date('D M j, Y g:i a T'), 0, false, 'L', 0, '', 0, false, 'T', 'M');
      // Page number
      if (empty($this->pagegroups)) {
        $pagenumtxt = $this->l['w_page'].' '.$this->getAliasNumPage().' / '.$this->getAliasNbPages();
      } else {
        $pagenumtxt = $this->l['w_page'].' '.$this->getPageNumGroupAlias().' / '.$this->getPageGroupAlias();
      }
      $this->Cell(0, 0, 'Page ' . $pagenumtxt, 0, false, 'R', 0, '', 0, false, 'T', 'M');
    }
  }

  public function MultiCell($w, $h, $txt, $border = 0, $align = 'J', $fill = false, $ln = 1, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false) {

    parent::MultiCell($w, $h, $txt, $border, $align, $fill, $ln, $x, $y, $reseth, $stretch, $ishtml, $autopadding, $maxh, $valign, $fitcell);
  }

}
