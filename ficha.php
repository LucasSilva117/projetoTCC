
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<title>Ficha de Atendimento</title>
<style>
  @page { size: A4; margin: 10mm; }
  body { font-family: Arial, sans-serif; margin: 0; }
  .page {
    width: 190mm;
    border: 1px solid #000;
    padding: 5mm;
    box-sizing: border-box;
  }
  .linha { display: flex; width: 100%; }
  .caixa { border: 1px solid #000; padding: 2px 4px; font-size: 11px; }
  .titulo-centro { text-align: center; font-weight: bold; font-size: 14px; margin-bottom: 2px; }
  input { width: 100%; border: none; border-bottom: 1px solid #000; }
  textarea { width: 100%; height: 35mm; border: none; border-bottom: 1px solid #000; resize: none; }
  .small-box { width: 20mm; }
  .mid-box { width: 40mm; }
  .big-box { flex: 1; }
</style>
</head>
<body>
<div class="page">

<div class="titulo-centro">SISTEMA ÚNICO DA SAÚDE DO ESTADO DE SÃO PAULO</div>
<div class="titulo-centro">FICHA DE PRONTO ATENDIMENTO MUNICIPAL</div>
<div style="text-align:center; font-size:11px; margin-bottom:4px;">
CNPJ 45.500.167/0001-64 — Município de Iguape — Rua XV de Novembro, 974 — Centro — CEP 11900-000
</div>

<!-- Linha Número/Ordem, Data, CNES -->
<div class="linha">
  <div class="caixa mid-box">Número / Ordem<br><input value="<?= htmlspecialchars($aten['ordem']) ?>"></div>
  <div class="caixa mid-box">Data / Atendimento<br><input value="<?= htmlspecialchars($aten['dataA']) ?>"></div>
  <div class="caixa mid-box">CNES<br><input value="<?= htmlspecialchars($aten['PLACEHOLDER']) ?>"></div>
</div>

<!-- Identificação -->
<div class="caixa" style="margin-top:3px; font-weight:bold;">IDENTIFICAÇÃO DO CLIENTE</div>

<div class="linha">
  <div class="caixa mid-box">CPF<br><input value="<?= htmlspecialchars($aten['CPFP']) ?>"></div>
  <div class="caixa mid-box">RG<br><input value="<?= htmlspecialchars($aten['RGP']) ?>"></div>
  <div class="caixa mid-box">CNS<br><input value="<?= htmlspecialchars($aten['CNSP']) ?>"></div>
</div>

<div class="linha">
  <div class="caixa big-box">Nome<br><input value="<?= htmlspecialchars($aten['nomeP']) ?>"></div>
  <div class="caixa small-box">Sexo<br><input value="<?= htmlspecialchars($aten['sexoP']) ?>"></div>
  <div class="caixa small-box">Idade<br><input value="<?= htmlspecialchars($aten['idadeP']) ?>"></div>
  <div class="caixa small-box">Mas/Ind<br><input value="<?= htmlspecialchars($aten['PLACEHOLDER']) ?>"></div>
</div>

<div class="linha">
  <div class="caixa big-box">Endereço<br><input value="<?= htmlspecialchars($aten['enderecoP']) ?>"></div>
</div>

<div class="linha">
  <div class="caixa big-box">Município residência<br><input value="<?= htmlspecialchars($aten['munResP']) ?>"></div>
  <div class="caixa small-box">Cód. Mun. Resid.<br><input value="<?= htmlspecialchars($aten['PLACEHOLDER']) ?>"></div>
  <div class="caixa small-box">UF<br><input value="<?= htmlspecialchars($aten['UFP']) ?>"></div>
</div>

<!-- ENFERMAGEM -->
<div class="caixa" style="margin-top:3px; font-weight:bold;">ENFERMAGEM</div>

<div class="linha">
  <div class="caixa mid-box">Diarréia? Sim/Não<br><input value="<?= htmlspecialchars($aten['temDiarreia']) ?>"></div>
  <div class="caixa mid-box">Data início sintomas<br><input value="<?= htmlspecialchars($aten['tempoSintomas']) ?>"></div>
  <div class="caixa big-box">Alergia? Sim/Não — Ao quê?<br><input value="<?= htmlspecialchars($aten['temAlergia'] . ' - ' . $aten['alergiaAque']) ?>"></div>
</div>

<div class="linha">
  <div class="caixa mid-box">Tosse +5 semanas: Sim/Não<br><input value="<?= htmlspecialchars($aten['tosseMais3sem']) ?>"></div>
  <div class="caixa mid-box">Colheita BK: Sim/Não<br><input value="<?= htmlspecialchars($aten['colheuBK']) ?>"></div>
</div>

<div class="linha">
  <div class="caixa small-box">PA<br><input value="<?= htmlspecialchars($aten['pressaoArterial']) ?>"></div>
  <div class="caixa small-box">Pulso<br><input value="<?= htmlspecialchars($aten['pulso']) ?>"></div>
  <div class="caixa small-box">Temp<br><input value="<?= htmlspecialchars($aten['temperatura']) ?>"></div>
  <div class="caixa small-box">FR<br><input value="<?= htmlspecialchars($aten['frequenciaResp']) ?>"></div>
  <div class="caixa small-box">Tax<br><input value="<?= htmlspecialchars($aten['peso']) ?>"></div>
  <div class="caixa small-box">Glicemia<br><input value="<?= htmlspecialchars($aten['glicemia']) ?>"></div>
  <div class="caixa small-box">SPO2<br><input value="<?= htmlspecialchars($aten['SPO']) ?>"></div>
</div>

<div class="caixa" style="margin-top:3px;">CLASSIFICAÇÃO DE RISCO — Vermelho • Amarelo • Verde • Azul<br><textarea></textarea></div>

<div class="caixa" style="margin-top:3px;">QUEIXA / HISTÓRICO (recente / usual)<br><textarea></textarea></div>

<!-- ANAMNESE -->
<div class="caixa" style="margin-top:3px; font-weight:bold;">ANAMNESE / EXAME CLÍNICO<br><textarea></textarea></div>

<!-- CONDUTA -->
<div class="caixa" style="margin-top:3px; font-weight:bold;">CONDUTA INICIAL<br><textarea></textarea></div>

<!-- SAME PROCEDIMENTOS -->
<div class="caixa" style="margin-top:3px; font-weight:bold;">SAME — PROCEDIMENTO</div>

<div class="linha" style="flex-wrap: wrap;">
  <div class="caixa small-box">OBS<br><input value="<?= htmlspecialchars($aten['PLACEHOLDER']) ?>"></div>
  <div class="caixa small-box">NBLZ<br><input value="<?= htmlspecialchars($aten['PLACEHOLDER']) ?>"></div>
  <div class="caixa small-box">EGG<br><input value="<?= htmlspecialchars($aten['PLACEHOLDER']) ?>"></div>
  <div class="caixa small-box">CUR<br><input value="<?= htmlspecialchars($aten['PLACEHOLDER']) ?>"></div>
  <div class="caixa small-box">DR. ABC<br><input value="<?= htmlspecialchars($aten['PLACEHOLDER']) ?>"></div>
  <div class="caixa small-box">IMOB<br><input value="<?= htmlspecialchars($aten['PLACEHOLDER']) ?>"></div>
  <div class="caixa small-box">GL CAP<br><input value="<?= htmlspecialchars($aten['PLACEHOLDER']) ?>"></div>
  <div class="caixa small-box">MED<br><input value="<?= htmlspecialchars($aten['PLACEHOLDER']) ?>"></div>
  <div class="caixa small-box">RET. PON<br><input value="<?= htmlspecialchars($aten['PLACEHOLDER']) ?>"></div>
  <div class="caixa small-box">SUT<br><input value="<?= htmlspecialchars($aten['PLACEHOLDER']) ?>"></div>
  <div class="caixa small-box">HID OR<br><input value="<?= htmlspecialchars($aten['PLACEHOLDER']) ?>"></div>
</div>

<div class="linha">
  <div class="caixa big-box">Hipót. Diag.<br><input value="<?= htmlspecialchars($aten['PLACEHOLDER']) ?>"></div>
  <div class="caixa small-box">CID<br><input value="<?= htmlspecialchars($aten['PLACEHOLDER']) ?>"></div>
  <div class="caixa small-box">Equipe<br><input value="<?= htmlspecialchars($aten['PLACEHOLDER']) ?>"></div>
  <div class="caixa small-box">Hor. Saída<br><input value="<?= htmlspecialchars($aten['PLACEHOLDER']) ?>"></div>
</div>

</div>
</body>
</html>
